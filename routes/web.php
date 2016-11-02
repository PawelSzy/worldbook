<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('kraj/{nazwa_kraju}/{json?}', "KrajController@wyswietlKraj");

Route::get('dane/{nazwa_kraju}/{idRekordu}/{json?}', "CzytajRekordController@czytajRekord");

Route::get('rankingi/{json?}', "RankingiController@wyswietlRankingi");

Route::get('ranking/{idRankingu}/{liczba_krajow?}/{json?}', "RankingiController@wyswietlRanking");

// Route::get('kraj/{nazwa_kraju}', function($nazwa_kraju) {
// 	echo $nazwa_kraju;
// });