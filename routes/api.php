<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('getresponse', 'OpayController@checkOrder');

Route::middleware('login')->post('login', 'ApiUsersController@login');
Route::post('register', 'ApiUsersController@store');

Route::middleware('checkApiToken')->group(function () {
    Route::post('logout', 'ApiUsersController@logout');
    Route::middleware('validateGameRecord')->post('addcoin', 'CoinController@addCoin');
    Route::middleware('validateGameRecord')->post('minuscoin', 'CoinController@minusCoin');
});

