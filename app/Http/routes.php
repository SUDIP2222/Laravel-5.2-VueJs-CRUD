<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/','EventController@index');
Route::post('api/events','EventController@store');
Route::get('api/events','EventController@getEvent');

Route::get('api/events/{id}','EventController@delete');

