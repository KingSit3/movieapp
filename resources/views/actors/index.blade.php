@extends('layout.layout')
@section('template')
    
    {{-- Popular Actors --}}
    <div class="container mx-auto px-4 pt-16 py-10">
        <div class="popular-actors">
            <h2 class="uppercase tracking-wider text-yellow-500 text-lg font-bold">Popular Actors</h2>   
            {{-- Cards Container Responsive --}}
            <div class="grid gap-20 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5  ">        
                {{-- Card --}}
                @foreach ($popularActors as $actor)
                    <div class="actor-card mt-8">
                        <a href="{{ route('actor.detail', ['id' => $actor['id']]) }}">
                            <img class="hover:opacity-75 transition ease-in-out duration-150" src="{{ $actor['profile_path'] }}" alt="Actors Image">
                        </a>
                        <div class="mt-2">
                        <a href="{{ route('actor.detail', ['id' => $actor['id']]) }}" class="text-lg hover:text-gray-300">{{ $actor['name'] }}</a>
                        <div class="text-small truncate text-gray-400">{{ $actor['known_for'] }}</div>
                        </div>
                    </div>
                @endforeach
                {{-- End Card --}}
            </div>
            {{-- End Cards Container Responsive --}}
        </div>
        <div class="flex justify-center pt-5">
            <button id="load-more" class=" text-gray-800 font-semibold bg-gray-400 py-3 px-6 rounded-lg">Load More</button>
        </div>

        {{-- Untuk pagination yang disediakan API --}}
        {{-- <div class="flex justify-between mt-16"> --}}
            {{-- @if ($previous)
                <a href="/actor/page/{{ $previous }}">Previous</a>
            @else  --}}
            {{-- Agar tetap pada posisi kiri --}}
                {{-- <div></div> --}}
            {{-- @endif --}}
            {{-- @if ($next) --}}
                {{-- <a href="/actor/page/{{ $next }}">Next</a> --}}
            {{-- @else  --}}
            {{-- Agar tetap pada posisi kanan --}}
                {{-- <div></div>
            @endif --}}
        {{-- </div> --}}
    </div>
    
    {{-- End Popular Actors --}}


@endsection