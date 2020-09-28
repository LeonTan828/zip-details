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

Route::get('/', 'HomeController@index');

Route::get('/locationdetails', 'ZipDetailsController@index');
Route::post('/locationdetails', 'ZipDetailsController@getDetails');

Route::get('/match', 'ZipMatchController@index');
Route::post('/match', 'ZipMatchController@checkMatch');