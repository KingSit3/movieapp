<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use function PHPSTORM_META\map;

class TvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getGenres()
    {
        // jika ada yang memanggil fungsi ini, kembalikkan data collection dari API MOVIEDB
        // Include token dari file service
        return collect(Http::withToken(config('services.tmdb.token'))
                            // Ambil data movie DB
                            ->get('https://api.themoviedb.org/3/genre/tv/list')
                            // Ubah ke json, lalu masuk ke genre
                            ->json()['genres'])
                        // Sambungkan antara kunci dengan data
                        ->mapWithKeys(function($genre){
                        // Untuk jadi id => nama genre
                        return [$genre['id'] => $genre['name']];
                        }); 
    }

    public function index()
    {
        // withToken() = file Config => services 
        // Tokennya disimpan disitu
                        
        $getPopular = collect(
                                // Ambil data collection dari API MOVIEDB
                                collect(Http::withToken(config('services.tmdb.token'))
                                        ->get('https://api.themoviedb.org/3/tv/popular')
                                        ->json()['results']
                                        // Ambil 10 data saja
                                        )->take(10)

                            // Lalu manipulasi datanya dengan map()
                            )->map(function($popularTv){
                                // Ambil data genre id yang masih berupa id saja (belum ada nama genrenya)
                                $genres = collect($popularTv['genre_ids'])
                                            // Pasangkan id yang disini dengan id yang di function getGenres()
                                            ->mapWithKeys(function($genre){
                                                // Hasilnya:    1 => western
                                                return [$genre => $this->getGenres()->get($genre)];
                                            });
                                
                                // Gabungkan/Ubah data yang diperlukan dengan merge()
                                return collect($popularTv)->merge([
                                        'poster_path' => 'https://image.tmdb.org/t/p/w500/'.$popularTv['poster_path'],
                                        'first_air_date' => Carbon::parse($popularTv['first_air_date'])->format('M d Y'),
                                        'vote_average' => $popularTv['vote_average'] * 10 . '%',
                                        'genre_ids' => $genres,
                                        ])
                                // Ambil array kunci ini saja, selebihnya buang
                                ->only('vote_average', 'first_air_date', 'poster_path', 'genre_ids', 'id', 'name' );
                            });

        $getTopRated = collect(
                            collect(Http::withToken(config('services.tmdb.token'))
                                ->get('https://api.themoviedb.org/3/tv/top_rated')
                                ->json()['results']
                                )->take(10)
                            )->map(function($topRated){
                                $genres = collect($topRated['genre_ids'])->mapWithKeys(function($genre){
                                     // Pasangkan id yang disini dengan id yang di function getGenres()
                                    //  $genre = id genre di fungsi ini, lalu cari id genre yang sama di fungsi getGenre()
                                    return [$genre => $this->getGenres()->get($genre)];
                                });

                                return collect($topRated)->merge([
                                    'poster_path' => 'https://image.tmdb.org/t/p/w500/'.$topRated['poster_path'],
                                    'first_air_date' => Carbon::parse($topRated['first_air_date'])->format('M d Y'),
                                    'vote_average' => $topRated['vote_average'] * 10 . '%',
                                    'genre_ids' => $genres,
                                ])->only('vote_average', 'first_air_date', 'poster_path', 'genre_ids', 'id', 'name' );

                            });
                  
        
        $data = [
            'popularTv' => $getPopular,
            'topRatedTv' => $getTopRated,
        ];

        return view('tv.index', $data);
    }

    public function show($id)
    {
        $getTvShow =    collect(Http::withToken(config('services.tmdb.token'))
                                ->get('https://api.themoviedb.org/3/tv/'.$id)
                                ->json());

        $tvShow = collect($getTvShow)->merge([
                        'vote_average' => $getTvShow['vote_average'] * 10 . '%',
                        'poster_path' => 'https://image.tmdb.org/t/p/w500/'.$getTvShow['poster_path'],
                        'first_air_date' => Carbon::parse($getTvShow['first_air_date'])->format('M d Y'),
                        'genres' => collect($getTvShow['genres'])->implode('name', ', '),
                        'created_by' => $getTvShow['created_by'][0]['name'],
                    ])->only('first_air_date', 'genres', 'name', 'poster_path', 'vote_average', 'overview', 'created_by');

        $getCast = collect(Http::withToken(config('services.tmdb.token'))
                            ->get('https://api.themoviedb.org/3/tv/'.$id.'/credits')
                            ->json()['cast'])->take(5);
        $cast = collect($getCast)->map(function($cast){
           return collect($cast)->merge([
                        'profile_path' => 'https://image.tmdb.org/t/p/w185/'. $cast['profile_path'],
                    ])->only('id', 'name', 'profile_path', 'character');
        });
        
        
        $getImage = collect(Http::withToken(config('services.tmdb.token'))
                            ->get('https://api.themoviedb.org/3/tv/'.$id.'/images')
                            ->json()['backdrops'])->take(6);
        $image = collect($getImage)->map(function($image){
                return collect($image)->merge([
                    'file_path' => 'https://image.tmdb.org/t/p/w185/'. $image['file_path'],
                ])->only('file_path');
        });

        $getVideo = Http::withToken(config('services.tmdb.token'))
                            ->get('https://api.themoviedb.org/3/tv/'.$id.'/videos?site=youtube')
                            ->json()['results'][0];
                            
        $video = collect($getVideo)->merge([
                               'id' => 'https://www.youtube.com/watch?v=HH1eloieu2U' . $getVideo['id']
                            ])->only('id');
        
        if(!$video)
        {
            $video = ['Tidak ada Trailer'];
        };
        
        
        // Ambil data movie->genre, lalu ambil name saja, lalu masing masing array tambahkan , 
        // Dijadikan agar tidak perlu loop di view
        // $genres = collect($movie['genres'])->implode('name', ', ');

        $data = [
                    'tvShow' => $tvShow,
                    'casts' => $cast,
                    'trailer' => $video,
                    'images' => $image,
                ];

        return view('tv.show', $data);
    }
}