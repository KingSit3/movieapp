<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ActorController extends Controller
{
    public $page;

    public function index($page = 1)
    {
        $popularActors = collect(Http::withToken(config('services.tmdb.token'))
                            ->get('https://api.themoviedb.org/3/person/popular?page='.$page)
                            // [results] biar Langusung masuk ke result
                            ->json()['results']);

        // Ubah ke format ini untuk dipassing ke view
        $formatActors = collect($popularActors)->map(function($actorsData){
            // Ubah/ganti array tadi dengan merge() agar siap digunakan
            return collect($actorsData)->merge([
                'profile_path' => $actorsData['profile_path']
                // Jika ada gambar profile, maka pakai
                ? 'https://image.tmdb.org/t/p/w235_and_h235_face'.$actorsData['profile_path']
                // Kalau tidak ada maka gambar random / nama 2 digit
                :  'https://ui-avatars.com/api/?size=235&name='.$actorsData['name'],
                'known_for' => collect($actorsData['known_for'])
                                // Dimana media type = movie
                                ->where('media_type', 'movie')
                                // Ambil title saja
                                ->pluck('title')
                                // Gabungkan dengan array lainnya agar menjadi 1 array
                                ->union(
                                    // Ambil data actor known_for
                                    collect($actorsData['known_for'])
                                    // Yang media typenya tv
                                    ->where('media_type', 'tv')
                                    // Ambil nama series
                                    ->pluck('name'))
                                // Pisahkan dengan koma
                                ->implode(', '),
            ])->only([
                'id', 'profile_path', 'name', 'known_for', 
            ]);
        }); 

        $data = [
                    'popularActors' => $formatActors,
                    'previous' => $page > 1 ? $page - 1 : null,
                    'next' => $page < 500 ? $page + 1 : null,
                ];
        return view('actors.index', $data);
    }

    public function detail($id)
    {
        $actor =  Http::withToken(config('services.tmdb.token'))
                            ->get('https://api.themoviedb.org/3/person/'.$id)
                            ->json();
        $social =  Http::withToken(config('services.tmdb.token'))
                            ->get('https://api.themoviedb.org/3/person/'.$id.'/external_ids')
                            ->json();
        $credits =  Http::withToken(config('services.tmdb.token'))
                            ->get('https://api.themoviedb.org/3/person/'.$id.'/combined_credits')
                            ->json()['cast'];

        $actorDetail = collect($actor)->merge([
                // Ubah ke format Jul 26, 1967
                'birthday' => Carbon::parse($actor['birthday'])->format('M d, Y'),
                // Dapatkan umurnya
                'age' => Carbon::parse($actor['birthday'])->age,
                'profile_path' => $actor['profile_path']
                //  Jika ada gambar profile, maka pakai
                ? 'https://image.tmdb.org/t/p/w300'.$actor['profile_path']
                // Kalau tidak ada maka gambar random / nama 2 digit
                :  'https://ui-avatars.com/api/?size=300&name='.$actor['name'],
            ])
            // Ambil hanya data ini saja
            ->only('biography', 'birthday', 'name', 'age', 'profile_path', 'place_of_birth');

        $socialDetail = collect($social)->merge([
            // Jika punya social media maka pakai, jika tidak maka null
            'imdb_id' => $social['imdb_id'] ? 'https://www.imdb.com/name/'.$social['imdb_id'] : null,
            'instagram_id' => $social['instagram_id'] ? 'https://www.instagram.com/'.$social['instagram_id'] : null,
            'twitter_id' => $social['twitter_id'] ? 'https://twitter.com/'.$social['twitter_id'] : null,
            'facebook_id' => $social['facebook_id'] ? 'https://id-id.facebook.com/'.$social['facebook_id'] : null,
            ])
            ->only('imdb_id', 'facebook_id', 'instagram_id', 'twitter_id');
        
        $knownForMovie = collect($credits)
                            ->where('media_type', 'movie')
                            ->sortByDesc('popularity')
                            ->take(5)
                            ->map(function($movie){
                                return collect($movie)->merge([
                                    'poster_path' => $movie['poster_path']
                                        // Jika ada gambar profile, maka pakai
                                        ? 'https://image.tmdb.org/t/p/w185'.$movie['poster_path']
                                        // Kalau tidak ada maka gambar random / nama 2 digit
                                        :  'https://ui-avatars.com/api/?size=235&name='.$movie['title'],
                                    'title' => isset($movie['title'])? $movie['title'] : 'Untitled',
                                ]);
                            });   

        $casts = collect($credits)->map(function($movie){
            
            if (isset($movie['release_date'])){
                $releaseDate = $movie['release_date'];
            } elseif(isset($movie['release_date'])){
                $releaseDate = $movie['first_air_date'];
            } else {
                $releaseDate = '';
            }

            if (isset($movie['title'])){
                $title = $movie['title'];
            } elseif(isset($movie['name'])){
                $title = $movie['name'];
            } else {
                $title = 'Untitled';
            }

            return collect($movie)
            ->merge([
            'release_date' => $releaseDate,
            // Jika ada release date, jika tidak maka null
            'release_year' => isset($releaseDate) ? Carbon::parse($releaseDate)->format('Y') : 'Future',
            // Jika ada karakter yang dimainkan
            'character' => isset($movie['character']) ? $movie['character'] : '',
            'title' => $title,
            ])
            ->only('release_date', 'release_year', 'character', 'title');
        })->sortByDesc('release_year');

        $data = [
                    'actor' => $actorDetail,
                    'social' => $socialDetail,
                    'movies' => $knownForMovie,
                    'credits' => $casts
                ];

        return view('actors.detail', $data);   
    }
}
