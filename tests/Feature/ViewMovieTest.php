<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewMovieTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function theMainpageShowsCorrectInfo()
    {
        // Rute yang akan di tes
        $response = $this->get(route('movie.index'));

        // Hasil yang diinginkan
        $response->assertStatus(200);
        $response->assertSee('Popular Movies');
    }
}
