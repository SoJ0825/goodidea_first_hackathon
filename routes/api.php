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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('getresponse', 'OpayController@checkOrder');

Route::middleware('login')->post('login', 'ApiUsersController@login');
Route::post('register', 'ApiUsersController@store');

Route::middleware('checkApiToken')->group(function () {
    Route::post('update', 'ApiUsersController@update');
    Route::post('logout', 'ApiUsersController@logout');
    Route::post('showcoin', 'CoinController@showCoin');
    Route::middleware('validateGameRecord')->post('addcoin', 'CoinController@addCoin');
    Route::middleware('validateGameRecord')->post('minuscoin', 'CoinController@minusCoin');
    Route::post('showrecord/{gameid}', 'GameRecordController@show');
    Route::post('getachievement', 'AchievementController@getAchievement');
    Route::post('showachievement', 'AchievementController@showAchievement');
    Route::post('checkwin', 'AchievementController@setWinTwice');
    Route::post('buyitem', 'BagController@buyItem');
    Route::post('showitem', 'BagController@showItem');
});

