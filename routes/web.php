<?php

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



Auth::routes(['register' => false, 'reset' => false]);

Route::group(['middleware' => ['auth', 'web']], function(){
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


    Route::get('/films/reload_films', function () {
        Artisan::call('command:import_films');
        return redirect('/');
    });
    Route::post('/films/searchbar', [App\Http\Controllers\FilmController::class, 'searchBar'])->name('film.searchbar');
    Route::resource('/films', App\Http\Controllers\FilmController::class);

});
