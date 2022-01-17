<?php

namespace App\View\Components;

use Illuminate\View\Component;

class tvCardComponent extends Component
{
    // Agar tersedia di view component
    public $tv;
    public $genreTv;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($tv)
    {
        //Masukkan nilai ke variabel
        $this->tv = $tv;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.tv-card-component');
    }
}
