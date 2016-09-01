<?php

Route::get('search', array('middleware' => 'cors', 'uses' => 'SearchController@search'));

Route::group(['middleware' => 'auth.basic'], function () {

    // Config
    Route::get('config', 'ConfigController@main');

    // Config - mice
    Route::get('config/mice/{mouse}', 'ConfigController@mouseDetails');
    Route::post('config/mice/add', 'ConfigController@addMouse');
    Route::get('config/mice/remove/{mouse}', 'ConfigController@removeMouse');
    Route::get('config/mice/update_wiki_urls', 'ConfigController@updateMiceWikiUrls');
    Route::patch('config/mice/{mouse}/update_wiki_url', 'ConfigController@updateMouseWikiUrl');


    // Config - locations
    Route::get('config/locations/{location}', 'ConfigController@locationDetails');
    Route::post('config/locations/add', 'ConfigController@addLocation');
    Route::get('config/locations/remove/{location}', 'ConfigController@removeLocation');

    // Config - cheeses
    Route::get('config/cheeses/{cheese}', 'ConfigController@cheeseDetails');
    Route::post('config/cheeses/add', 'ConfigController@addCheese');
    Route::get('config/cheeses/remove/{cheese}', 'ConfigController@removeCheese');

    // Config - stages
    Route::get('config/stages/{stage}', 'ConfigController@stageDetails');
    Route::post('config/stages/add', 'ConfigController@addStage');
    Route::get('config/stages/remove/{stage}', 'ConfigController@removeStage');

    // Config - setups
    Route::post('config/setups/add', 'ConfigController@addSetup');
    Route::get('config/setups/remove/{setup}', 'ConfigController@removeSetup');

});
