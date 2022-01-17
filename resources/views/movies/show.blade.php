@extends('layout.layout')
@section('template')
    
    {{-- Movie Info --}}
        <div class="movie-info border-b border-gray-800">
            <div class="container mx-auto px-4 py-16 flex flex-col md:flex-row">
                <img src="{{ 'https://image.tmdb.org/t/p/w500/'.$movie['poster_path'] }}" alt="Poster" class="mx-auto w-64 md:w-80 lg:w-96">
                
                <div class="md:ml-24">
                    <h2 class="text-4xl font-semibold">{{ $movie['title'] }}</h2>
                    <div class="flex flex-wrap items-center text-gray-400 text-sm mt-2">
                                <svg class="fill-current text-yellow-500 w-4 my-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            <Span class="ml-1">{{ $movie['vote_average'] *10 .'%' }}</Span>
                            <Span class="mx-2">|</Span>
                            <Span>{{  \Carbon\Carbon::parse($movie['release_date'])->format('M d Y') }}</Span>
                            <Span class="mx-2">|</Span>
                            <span>{{ $genres }}</span>
                        </div>
                        <p class="text-gray-300 mt-8">
                            {{ $movie['overview'] }}
                        </p>

                        <div class="mt-12">
                            <h4 class="text-white font-semibold">Featured Crew</h4>
                            <div class="flex mt-4">
                                @foreach ($crews as $crew)
                                    <div @if(!$loop->first) class="ml-10" @endif>
                                        <div>{{ $crew['name'] }}</div>
                                        <div class="text-sm text-gray-400">{{ $crew['known_for_department'] }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    <div x-data="{isOpen: false}">
                        @if ($video)
                            <div class="mt-12">
                                <button @click="isOpen = true" class="inline-flex items-center bg-yellow-500 text-gray-900 rounded font-semibold px-5 py-4 hover:bg-yellow-300 transition ease-in-out duration-200">
                                    <svg class="w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="ml-2">Play Trailer</span>
                                </button>
                            </div>
                        @endif

                    {{-- Model Trailer --}}
                    <div x-show.transition.in.duration.200ms.out.duration.150ms="isOpen" class="fixed top-0 left-0 w-full h-full flex items-center shadow-lg overflow-y-auto">
                        <div class="container mx-auto lg:px-32 rounded-lg overflow-y-auto">
                            <div class="bg-gray-900 rounded">
                                <div class="flex justify-end pr-4 pt-2 ">
                                    <button @click=" isOpen=false " class="text-3xl leading-none hover:text-red-600 appearance-none">
                                        &times;
                                    </button>
                                </div>
                                <div class="modal-body px-8 py-8">
                                    <div class="responsive-container overflow-hidden relative" style="padding-top: 56.25%">
                                    <iframe width="560" height="315" class="responsive-iframe absolute top-0 left-0 w-full h-full" src="" allow="autoplay; encrypted-media" allowfullscreen frameborder="0"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    {{-- End Modal Trailer --}}

                </div>
                
            </div>
        </div>
    {{-- End Movie Info --}}

    {{-- Movie Cast --}}
        <div class="movie-cast border-b border-gray-800">
            <div class="container mx-auto px-4 py-16">
                <h2 class="text-4xl font-semibold">Cast</h2>
            
                <div class="grid gap-20 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">
                    
                    {{-- Cast Card --}}
                    @foreach ($casts as $cast)
                        <div class="mt-8">
                            <a href="{{ route('actor.detail', ['id' => $cast['id']]) }}"><img src="{{ 'https://image.tmdb.org/t/p/w500/'.$cast['profile_path'] }}" alt="TEsting" class="hover:opacity-75 transition ease-in-out duration-200"></a>
                            <h2 class="text-lg mt-2 text-gray-300 font-semibold">{{ $cast['name'] }}</h2>
                            <h4 class="text-sm text-gray-300">{{ $cast['character'] }}</h4>
                        </div>
                    @endforeach
                    {{-- End Cast Card --}}
                    
                </div>
            </div>
        </div>
    {{-- End Movie Cast --}}

    {{-- Pictures --}}
        {{-- Simpan x-data awal image & status open --}}
        <div class="pictures border-b text-gray-800" x-data="{isOpen:false, image:''}">
            <div class="container mx-auto px-5 py-5">
                <h2 class="text-4xl text-semibold text-gray-200">Pictures</h2>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-10 mt-8">
                    @foreach ($images as $image)
                    {{-- .prevent = agar tidak langsung terbuka --}}
                        <a 
                            @click.prevent="
                            isOpen=true
                            image='{{'https://image.tmdb.org/t/p/original/'.$image['file_path'] }}' " href="#" @click="isOpen = true"><img src="{{'https://image.tmdb.org/t/p/w500/'.$image['file_path'] }}" alt="Gambar"></a>
                    @endforeach
                </div>
            </div>

                {{-- Picture Model --}}
                <div x-show.transition.in.duration.200ms.out.duration.150ms="isOpen" class="fixed top-0 left-0 w-full h-full flex items-center shadow-lg overflow-y-auto">
                        <div class="container mx-auto lg:px-32 rounded-lg overflow-y-auto">
                            <div class="bg-gray-900 rounded">
                                <div class="flex justify-end pr-4 pt-2 ">
                                    <button @click=" isOpen=false " class="text-3xl leading-none text-gray-300 hover:text-red-600 appearance-none">
                                        &times;
                                    </button>
                                </div>
                                <div class="modal-body px-8 py-8">
                                    {{-- :src =  untuk mengambil data dari image data alpine JS --}}
                                   <img :src="image" alt="Images">
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Picture Model --}}
                </div>

        </div>
    {{-- End Pictures --}}

@endsection