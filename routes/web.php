<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('getresponse', 'OpayController@test');

Auth::routes();

Route::get('home', 'HomeController@index')->name('home');

//Route::get('addValue', 'OpayController@showOrder')->name('addValue');
Route::get('addValue', 'OpayController@showMenu');
Route::post('addValue', 'OpayController@showMenu')->name('addValue');
Route::middleware('auth')->post('sentOrder', 'OpayController@sentOrder');
