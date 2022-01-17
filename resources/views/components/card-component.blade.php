<div class="mt-8">
    <a href="{{ route('movie.show', ['id' => $movie['id']]) }}" ><img src="https://image.tmdb.org/t/p/w500/{{ $movie['poster_path'] }}" alt="Poster" class="hover:opacity-75 transition ease-in-out duration-200"></a>
    <div class="mt-2">
        <a href="{{ route('movie.show', ['id' => $movie['id']]) }}" class="text-lg mt-2 hover:text-gray-300">{{ $movie['title'] }}</a>
    </div> 
    <div class="flex items-center text-gray-400 text-sm">
            <svg class="fill-current text-yellow-500 w-4 my-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
            </svg>
        <Span class="ml-1">{{ $movie['vote_average'] * 10 . '%' }}</Span>
        <Span class="mx-2">|</Span>
        {{-- Pakai Carbon untuk tanggal feb 17 2020 --}}
        <Span>{{ \Carbon\Carbon::parse($movie['release_date'])->format('M d Y') }}</Span>
    </div>
    <div class="text-gray-400 text-sm">
        {{-- Looping Id genre dari api popular movies --}}
        @foreach ($movie['genre_ids'] as $genre)
            {{-- Ambil data genre(controller) lalu pasangkan dengan Id genre --}}
            {{-- IF looping terakhir maka tidak pakai koma --}}
            {{ $genreMovie->get($genre) }}@if (!$loop->last), @endif
        @endforeach
    </div>
</div>