<?php

use App\Http\Controllers\ActorController;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\TvController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [MoviesController::class, 'index'])->name('movie.index');
Route::get('/movies/{id}', [MoviesController::class, 'show'])->name('movie.show');

Route::get('actor', [ActorController::class, 'index'])->name('actor.index');
Route::get('actor/page/{page?}', [ActorController::class, 'index']);
Route::get('actor/{id}', [ActorController::class, 'detail'])->name('actor.detail');

Route::get('tv', [TvController::class, 'index'])->name('tv.index');
Route::get('/tv/{id}', [TvController::class, 'show'])->name('tv.show');