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

//Route::get('/', 'SearchController@main');

Route::get('search', array('middleware' => 'cors', 'uses' => 'SearchController@search'));

Route::get('mice/{mouse}', 'SearchController@mouseDetails');
Route::get('locations/{location}', 'SearchController@locationDetails');
Route::get('stages/{stage}', 'SearchController@stageDetails');
Route::get('cheeses/{cheese}', 'SearchController@cheeseDetails');

Route::group(['middleware' => 'auth.basic'], function () {

    // Config
    Route::get('config', 'ConfigController@main');
//    Route::get('config', array('middleware' => 'auth.basic', 'uses' => 'ConfigController@main'));

    // Config - mice
    Route::post('config/mice/add', 'ConfigController@addMouse');
    Route::get('config/mice/remove/{mouse}', 'ConfigController@removeMouse');
    Route::get('config/mice/update_wiki_urls', 'ConfigController@updateMiceWikiUrls');


    // Config - locations
    Route::post('config/locations/add', 'ConfigController@addLocation');
    Route::get('config/locations/remove/{location}', 'ConfigController@removeLocation');

    // Config - cheeses
    Route::post('config/cheeses/add', 'ConfigController@addCheese');
    Route::get('config/cheeses/remove/{cheese}', 'ConfigController@removeCheese');

    // Config - stages
    Route::post('config/stages/add', 'ConfigController@addStage');
    Route::get('config/stages/remove/{stage}', 'ConfigController@removeStage');

    // Config - setups
    Route::post('config/setups/add', 'ConfigController@addSetup');
    Route::get('config/setups/remove/{setup}', 'ConfigController@removeSetup');

});
