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

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

Route::get('/', 'MovieController@listing')->name('listing');

Route::group(['middleware' => 'auth'], function () {
    Route::post('/movies/rent', 'RentalController@rent');
    Route::resource('/movies', 'MovieController');

    Route::get('/rentals/history', 'RentalController@rentalHistory')->name('history');
    Route::get('/rentals/return', 'RentalController@returnMovie')->name('return');
    Route::post('/rentals/processReturn', 'RentalController@processReturn')->name('processReturn');
});

Route::get('/home', 'HomeController@index')->name('home');
