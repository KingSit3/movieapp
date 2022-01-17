<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    {{-- Include Style Livewire --}}
    @livewireStyles
    {{-- Include Alpine JS --}}
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.min.js" defer></script>
    
    <title>Movie App</title>
</head>
<body class="font-sans bg-gray-900 text-white">
    <nav class="border-b border-gray-800">
        <div class="container mx-auto flex flex-col md:flex-row items-center justify-between px-4 py-6">
            <ul class="flex flex-col md:flex-row items-center">
                <li class="md:ml-6">
                    <a href="#">
                        <svg class="w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" /> 
                        </svg>
                    </a>
                </li>
                <li class="md:ml-16 mt-3 md:mt-3">
                    <a href="/" class="hover:text-gray-300">Movies</a>
                </li>
                <li class="md:ml-6 mt-3 md:mt-3">
                    <a href="/tv" class="hover:text-gray-300">TV Shows</a>
                </li>
                <li class="md:ml-6 mt-3 md:mt-3">
                    <a href="/actor" class="hover:text-gray-300">Actors</a>
                </li>
            </ul>
            
            {{-- Search --}}
            <div class="flex flex-col md:flex-row items-center">
                <livewire:search-dropdown />
                
                <div class="md:ml-4 mt-3 md:mt-3">
                    <a href="#">
                        <img src="{{ asset('logo/avatar.png') }}" alt="Avatar" class="rounded-full w-8 h-8">
                    </a>
                </div>
                
            </div>

        </div>
    </nav>


    @yield('template')

{{-- Include Script Livewire --}}
@livewireScripts
<script src="https://unpkg.com/infinite-scroll@3/dist/infinite-scroll.pkgd.min.js"></script>
<script>
    var elem = document.querySelector('.grid');
    var infScroll = new InfiniteScroll( elem, {
    // options
    // Kalau mau pakai blade template di Javascript harus ditambahkan @
    path: '/actor/page/@{{#}}',
    append: '.actor-card',
    // Agar tidak ada page di url
    // history: false,
    // Agar mati scrool secara otomatis, diganti dengan tekan tombol
    scrollThreshold: false,
    // Tombol load more
    button: '#load-more',
    });
</script>
</body>
</html>