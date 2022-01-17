{{-- State untuk JS --}}
<div class="relative  mt-3 md:mt-3" x-data="{ isOpen: true}" @click.away="isOpen = false">
    {{-- Wire:model == kirim data "search" ke controller Livewire, lalu update variabel $search --}}
    {{-- Debounce itu untuk delay request | delay request 500 ms --}}
    {{-- Keydown.escape = pencetan keyboard ESC, lalu tutup hasil search --}}
    {{-- @focus Saat kembali klik input bar, maka buka hasil search --}}
    <input wire:model.debounce.500ms="search" type="text" class="bg-gray-800 rounded-full w-64 px-4 pl-9 py-1 text-sm focus:outline-none focus:shadow-outline " @focus="isOpen = true" @keydown.escape.window="isOpen = false" @keydown.shift.tab="isOpen = false" placeholder="Search">
    <div class="absolute top-0">
        <li class="fas fa-fw fa-search mt-2 ml-2"></li>
    </div>

    <div wire:loading class="">Getting Data...</div>

    @if (strlen($search) > 2)
    {{-- Z-50 adalah posisi z paling tinggi, Stack paling atas --}}
    {{-- x-show untuk switch | baca dokumentasi Alpine JS --}}
    <div class="z-50 absolute bg-gray-800 rounded w-64 mt-4" x-show.transition="isOpen">
        <ul>
            {{-- Jika data lebih dari 0 maka tampilkan datanya --}}
            @if (count($searchResult) > 0)
                @foreach ($searchResult as $result)
                    <li class="border-b border-gray-700">
                        <a href="{{ route('movie.show', ['id' => $result['id']]) }}" class="hover:bg-green-500 py-3 px-3 flex capitalize items-center">
                            <img class="w-8" src="https://image.tmdb.org/t/p/w92/{{ $result['poster_path'] }}" alt="Poster">
                            <span class="ml-3">{{ $result['title'] }}</span>
                        </a>
                    </li>
                @endforeach
            @else
                <div class="px-3 py-3 capitalize">no result for "{{ $search }}"</div>
            @endif
        </ul>
    </div>
    @endif

</div>
