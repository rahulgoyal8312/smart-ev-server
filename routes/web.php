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
Route::get('/get_data/{id}', 'UserController@getData');
Route::get('/add_data', 'UserController@addData');
Route::get('/station_add_data','StationController@addData');
Route::get('/station_get_data/{id}', 'StationController@getData');
