<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class SearchDropdown extends Component
{
    // Deklarasi variabel disini otomatis bisa dipakai di view
    public $search = '';

    public function render()
    {   
        // Biar tidak dianggap 0 / error
        $searchResult = [];

        // Jika ada ketikan lebih 2 huruf maka lakukan pencarian movie
        if (strlen($this->search) > 2 ) {
            $searchResult = collect(Http::withToken(config('services.tmdb.token'))
                                        // Ambil data dari public $search
                                        ->get('https://api.themoviedb.org/3/search/movie?query='.$this->search)
                                        ->json()['results'])->take(5);
            
        }
        $data = [
                    'searchResult' => $searchResult,
                ];
        // dump($data['searchResult']);

        return view('livewire.search-dropdown', $data);
    }
}
