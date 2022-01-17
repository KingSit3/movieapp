<?php

namespace App\View\Components;

use Illuminate\View\Component;

class cardComponent extends Component
{
    // Agar tersedia di view component
    public $movie;
    public $genreMovie;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($movie, $genreMovie)
    {
        //Masukkan nilai ke variabel
        $this->movie = $movie;
        $this->genreMovie = $genreMovie;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.card-component');
    }
}
