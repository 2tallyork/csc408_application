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

Route::group(['middleware' => 'cors'], function () {
    Route::get('/customers/{id}/rentals', 'ApiUserController@rentals');
    Route::resource('/customers', 'ApiUserController');

    Route::get('/movies/{id}/rentals', 'ApiMovieController@rentals');
    Route::resource('/movies', 'ApiMovieController');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
