<?php

$router->get('search', ['middleware' => 'cors', 'uses' => 'SearchController@search']);
$router->get('link', ['middleware' => 'cors', 'uses' => 'SearchController@shortlink']);

//$router->group(['middleware' => 'auth.basic'], function () use ($router) {
$router->group(['middleware' => 'auth.basic'], function () use ($router) {

    // Config
    $router->get('config', 'ConfigController@main');

    // Config - mice
    $router->get('config/mice/{mouse}', 'ConfigController@mouseDetails');
    $router->post('config/mice/add', 'ConfigController@addMouse');
    $router->get('config/mice/remove/{mouse}', 'ConfigController@removeMouse');
    $router->get('config/mice/update/missing_wiki_urls', 'ConfigController@updateMiceMissingWikiUrls');
    $router->patch('config/mice/{mouse}/update_wiki_url', 'ConfigController@updateMouseWikiUrl');
    $router->patch('config/mice/{mouse}/update_ht_id', 'ConfigController@updateMouseHTID');

    // Config - locations
    $router->get('config/locations/{location}', 'ConfigController@locationDetails');
    $router->post('config/locations/add', 'ConfigController@addLocation');
    $router->get('config/locations/remove/{location}', 'ConfigController@removeLocation');

    // Config - cheeses
    $router->get('config/cheeses/{cheese}', 'ConfigController@cheeseDetails');
    $router->post('config/cheeses/add', 'ConfigController@addCheese');
    $router->get('config/cheeses/remove/{cheese}', 'ConfigController@removeCheese');

    // Config - stages
    $router->get('config/stages/{stage}', 'ConfigController@stageDetails');
    $router->post('config/stages/add', 'ConfigController@addStage');
    $router->get('config/stages/remove/{stage}', 'ConfigController@removeStage');

    // Config - setups
    $router->post('config/setups/add', 'ConfigController@addSetup');
    $router->get('config/setups/remove/{setup}', 'ConfigController@removeSetup');

});
