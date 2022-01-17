@extends('layout.layout')
@section('template')
    
    {{-- Popular movies --}}
    <div class="container mx-auto px-4 pt-16">
        <div class="popular-movies">
            <h2 class="uppercase tracking-wider text-yellow-500 text-lg font-bold">Popular Movies</h2>   
            {{-- Cards Container Responsive --}}
            <div class="grid gap-20 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5  ">        
                {{-- Card --}}
                @foreach ($popularMovies as $movie)
                    {{-- Pakai Component --}}
                    <x-card-component :movie="$movie" :genreMovie='$genreMovie' />

                @endforeach
                {{-- End Card --}}
            </div>
            {{-- End Cards Container Responsive --}}
        </div>
    </div>

    {{-- Now Playing --}}
    <div class="container mx-auto px-4 pt-16 mb-8">
        <div class="now-playing">
            <h2 class="uppercase tracking-wider text-yellow-500 text-lg font-bold">Now Playing</h2>
            {{-- Cards Container Responsive --}}
            <div class="grid gap-20 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5  ">          
                {{-- Card --}}
                @foreach ($nowPlaying as $movie)

                    {{-- Pakai Component kirim data tv dan genreTV --}}
                    <x-card-component :movie="$movie" :genreMovie='$genreMovie' />

                @endforeach
                {{-- End Card --}}
            </div>
            {{-- End Cards Container Responsive --}}
        </div>
    </div>

@endsection