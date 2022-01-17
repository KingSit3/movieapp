@extends('layout.layout')
@section('template')
    
    {{-- Popular tv --}}
    <div class="container mx-auto px-4 pt-16">
        <div class="popular-tv">
            <h2 class="uppercase tracking-wider text-yellow-500 text-lg font-bold">Popular Shows</h2>   
            {{-- Cards Container Responsive --}}
            <div class="grid gap-20 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5  ">        
                
                @foreach ($popularTv as $popular)
                    {{-- Card --}}
                        {{-- Pakai Component --}}
                        <x-tv-card-component :tv='$popular' />
                    {{-- End Card --}}
                @endforeach

            </div>
            {{-- End Cards Container Responsive --}}
        </div>
    </div>

    {{-- Top Rated Shows --}}
    <div class="container mx-auto px-4 pt-16 mb-8">
        <div class="now-playing">
            <h2 class="uppercase tracking-wider text-yellow-500 text-lg font-bold">Top Rated Shows</h2>
            {{-- Cards Container Responsive --}}
            <div class="grid gap-20 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5  "> 

                {{-- Card --}}
                    @foreach ($topRatedTv as $topRated)
                        {{-- Pakai Component kirim data tv--}}
                        <x-tv-card-component :tv='$topRated' />
                    @endforeach
                {{-- End Card --}}
                
            </div>
            {{-- End Cards Container Responsive --}}
        </div>
    </div>

@endsection