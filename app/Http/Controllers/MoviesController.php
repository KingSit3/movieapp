<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // withToken() = file Config => services 
        // Tokennya disimpan disitu
        $genres = Http::withToken(config('services.tmdb.token'))
                            ->get('https://api.themoviedb.org/3/genre/movie/list')
                            // [genres] biar Langusung masuk ke genres
                            ->json()['genres'];

        // Pakai collection Untuk Manipulasi Array
        $popularMovies = collect(Http::withToken(config('services.tmdb.token'))
                            ->get('https://api.themoviedb.org/3/movie/popular')
                            // [results] biar Langusung masuk ke result
                            ->json()['results'])
                            // Take untuk limit 10 saja
                            ->take(10);

        $nowPlaying = collect(Http::withToken(config('services.tmdb.token'))
                            ->get('https://api.themoviedb.org/3/movie/now_playing')
                            // [results] biar Langusung masuk ke result
                            ->json()['results'])
                            // Take untuk limit 10 saja
                            ->take(10);
    
        $data = [
                    
                    'popularMovies' => $popularMovies,
                    'nowPlaying' => $nowPlaying,
                    'genreMovie' => collect($genres)->mapWithKeys(function($genre){
                        // Untuk jadi id => nama genre
                        return [$genre['id'] => $genre['name']];
                    }),
                ];

        dump($data['popularMovies']);

        return view('movies.home', $data);
    }
 
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $movie = Http::withToken(config('services.tmdb.token'))
                            ->get('https://api.themoviedb.org/3/movie/'.$id)
                            ->json();
        $cast = collect(Http::withToken(config('services.tmdb.token'))
                            ->get('https://api.themoviedb.org/3/movie/'.$id.'/credits')
                            ->json()['cast'])->take(5);
        $crew = collect(Http::withToken(config('services.tmdb.token'))
                            ->get('https://api.themoviedb.org/3/movie/'.$id.'/credits')
                            ->json()['crew'])->take(4);
        $image = collect(Http::withToken(config('services.tmdb.token'))
                            ->get('https://api.themoviedb.org/3/movie/'.$id.'/images')
                            ->json()['backdrops'])->take(6);                    
        
        $video = Http::withToken(config('services.tmdb.token'))
                            ->get('https://api.themoviedb.org/3/movie/'.$id.'/videos?site=youtube')
                            ->json()['results'];
        if(!$video)
        {
            $video = ['Tidak ada Trailer'];
        };
        
        // Ambil data movie->genre, lalu ambil name saja, lalu masing masing array tambahkan , 
        // Dijadikan agar tidak perlu loop di view
        $genres = collect($movie['genres'])->implode('name', ', ');

        $data = [
                    'movie' => $movie,
                    'casts' => $cast,
                    'crews' => $crew,
                    'images' => $image,
                    'video' => $video,
                    'genres' => $genres,
                ];

        return view('movies.show', $data);
    }
}
