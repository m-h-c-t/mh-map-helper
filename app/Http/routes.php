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

Route::get('/', 'SearchController@main');

Route::get('search', 'SearchController@search');

// Config
Route::get('config', array('middleware' => 'auth.basic', 'uses' => 'ConfigController@main'));

// Config - mice
Route::post('config/mice/add', array('middleware' => 'auth.basic', 'uses' => 'ConfigController@addMouse'));
Route::get('config/mice/remove/{mouse}', array('middleware' => 'auth.basic', 'uses' => 'ConfigController@removeMouse'));

// Config - locations
Route::post('config/locations/add', array('middleware' => 'auth.basic', 'uses' => 'ConfigController@addLocation'));
Route::get('config/locations/remove/{location}', array('middleware' => 'auth.basic', 'uses' => 'ConfigController@removeLocation'));

// Config - cheeses
Route::post('config/cheeses/add', array('middleware' => 'auth.basic', 'uses' => 'ConfigController@addCheese'));
Route::get('config/cheeses/remove/{cheese}', array('middleware' => 'auth.basic', 'uses' => 'ConfigController@removeCheese'));
