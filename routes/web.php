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

use Illuminate\Support\Facades\Route;
Route::get('/',function(){
	return view('welcome');
});
Route::get('/get_user/{user_id}', 'UserController@getUser');
Route::post('/add_user', 'UserController@addUser');
Route::post('/add_station','StationController@addStation');
Route::get('/get_station/{id}', 'StationController@getStation');
Route::post('/get_nearest_stations','StationController@getNearestStations');
Route::get('/search_station/{name}','StationController@searchStation');