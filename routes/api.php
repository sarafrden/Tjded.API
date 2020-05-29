<?php
use Illuminate\Http\Request;
Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');

    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');

    //Providers

        Route::post('Providers/create', 'ProviderController@create');
        Route::post('Providers/{id}/update', 'ProviderController@update');
        Route::post('Providers/{id}/delete', 'ProviderController@delete');

    //Items

        Route::post('Items/create', 'ItemController@create');
        Route::post('Items/{id}/update', 'ItemController@update');
        Route::get('Items/{id}/delete', 'ItemController@delete');


    //Categories

        Route::post('categories/create', 'CategoryController@create');
        Route::post('categories/{id}/update', 'CategoryController@update');
        Route::get('categories/{id}/delete', 'CategoryController@delete');

    //replays

        Route::post('replays/create', 'ReplayController@create');
        Route::post('replays/{id}/update', 'ReplayController@update');
        Route::get('replays/{id}/delete', 'ReplayController@delete');


    //Users
        Route::get('users/{id}/delete', 'UserController@delete');



    });

});

Route::post('Providers/getList', 'ProviderController@getList');
Route::get('Providers/getById/{id}', 'ProviderController@getById');


Route::post('Items/getList', 'ItemController@getList');
Route::get('Items/{id}/getById', 'ItemController@getById');
Route::post('Items/getListWithCategory', 'ItemController@getListWithCategory');
Route::post('Items/{id}/getReplay', 'ItemController@getReplay');


Route::post('categories/getList', 'CategoryController@getList');
Route::post('categories/{id}/getItems', 'CategoryController@getItems');


Route::post('replays/getList', 'ReplayController@getList');
Route::get('replays/{id}/getById', 'ReplayController@getById');

Route::post('Usres/getList', 'UsreController@getList');
Route::get('Usres/{id}/getById', 'UsreController@getById');
