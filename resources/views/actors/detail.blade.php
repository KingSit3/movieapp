@extends('layout.layout')
@section('template')
    
    {{-- Actor Info --}}
        <div class="actor-info border-b border-gray-800">
            <div class="container mx-auto px-4 py-16 flex flex-col md:flex-row">
                <div class="flex-none">
                    <img src="{{ $actor['profile_path'] }}" alt="Poster" class="w-64 md:w-80 lg:w-96">
                    
                    <ul class="flex mt-4">
                        @if ($social['facebook_id'])
                            <li class="mr-4">
                                <a href="{{ $social['facebook_id'] }}" title="Facebook">
                                    <i class="fab fa-facebook-square fa-lg"></i>
                                </a>
                            </li>
                        @endif

                        @if ($social['twitter_id'])
                            <li class="mr-4">
                                <a href="{{ $social['twitter_id'] }}" title="Twitter">
                                    <i class="fab fa-twitter fa-lg"></i>
                                </a>
                            </li>
                        @endif

                        @if ($social['instagram_id'])
                            <li class="mr-4">
                                <a href="{{ $social['instagram_id'] }}" title="Instagram">
                                    <i class="fab fa-instagram fa-lg"></i>
                                </a>
                            </li>
                        @endif

                        @if ($social['imdb_id'])
                            <li class="mr-4">
                                <a href="{{ $social['imdb_id'] }}" title="imdb">
                                    <i class="fab fa-imdb fa-lg"></i>
                                </a>
                            </li>
                        @endif
                    </ul>

                </div>
            {{-- Overview --}}
                <div class="md:ml-24">
                    <h2 class="text-4xl font-semibold">{{ $actor['name'] }}</h2>
                    <div class="flex flex-wrap items-center text-gray-400 text-sm mt-2">
                            <svg class="fill-none text-gray-300 w-4 my-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z" />
                            </svg>
                        <Span class="ml-2">{{ $actor['birthday'] }} ({{ $actor['age'] }} years old) in  {{ $actor['place_of_birth'] }}</Span>
                    </div>
                    <p class="text-gray-300 mt-8">
                        {{ $actor['biography'] }}
                    </p>

                    <h4 class="font-semibold mt-12">Known For</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-8">
                        @foreach ($movies as $movie)
                            <div class="mt-4">
                                <a href="{{ route('movie.show', ['id' => $movie['id']]) }}">
                                    <img class="hover:opacity-75 transition ease-in-out duration-200" src="{{ $movie['poster_path'] }}" alt="Movie">
                                </a>
                                    <a href="{{ route('movie.show', ['id' => $movie['id']]) }}" class="text-sm leading-normal block text-gray-400 hover:text-white mt-1">{{ $movie['title'] }}</a>
                            </div>
                        @endforeach
                    </div>
                    
                </div>
                {{-- End Overview --}}

            </div>
        </div>
    {{-- End Actor Info --}}

    {{-- Credits --}}
        <div class="credits border-b border-gray-800">
            <div class="container mx-auto px-4 py-16">
                <h2 class="text-4xl font-semibold">Credits</h2>
                <ul class="list-disc leading-loose pl-5 mt-8">
                    @foreach ($credits as $credit)
                        <li>{{ $credit['release_year'] }} &middot; <strong>{{ $credit['title'] }}</strong> as {{ $credit['character'] }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    {{-- End Credits --}}

@endsection