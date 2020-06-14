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
        Route::post('Providers/{id}/delete', 'ProviderController@delete')->middleware('can:isAdmin');
        Route::post('Providers/rate/{id}', 'ProviderController@rate');

    //Items

        Route::post('Items/create', 'ItemController@create');
        Route::post('Items/{id}/update', 'ItemController@update');
        Route::get('Items/{id}/delete', 'ItemController@delete');


    //Categories

        Route::post('categories/create', 'CategoryController@create')->middleware('can:isAdmin');
        Route::post('categories/{id}/update', 'CategoryController@update')->middleware('can:isAdmin');
        Route::get('categories/{id}/delete', 'CategoryController@delete')->middleware('can:isAdmin');

    //replays

        Route::post('replays/create', 'ReplayController@create')->middleware('can:provider');
        Route::post('replays/{id}/update', 'ReplayController@update')->middleware('can:provider');
        Route::get('replays/{id}/delete', 'ReplayController@delete')->middleware('can:provider');


    //Users
        Route::get('users/{id}/delete', 'UserController@delete')->middleware('can:isAdmin');

    //Messages
        Route::get('messages', 'ChatsController@fetchMessages');
        Route::post('messages', 'ChatsController@sendMessage');

    });

});

Route::post('Providers/getList', 'ProviderController@getList');
Route::get('Providers/getById/{id}', 'ProviderController@getById');
Route::post('Providers/{id}/getRate', 'ProviderController@getRate');


Route::post('Items/getList', 'ItemController@getList');
Route::get('Items/{id}/getById', 'ItemController@getById');
Route::post('Items/getListWithCategory', 'ItemController@getListWithCategory');
Route::post('Items/{id}/getReplay', 'ItemController@getReplay');


Route::post('categories/getList', 'CategoryController@getList');
Route::post('categories/{id}/getItems', 'CategoryController@getItems');


Route::post('replays/getList', 'ReplayController@getList');
Route::get('replays/{id}/getById', 'ReplayController@getById');

Route::post('Users/getList', 'UserController@getList');
Route::get('Users/{id}/getById', 'UserController@getById');


Route::post('Users', 'AuthController@sendOtp');

Route::post('user/getOTP', 'UserController@getOTP');
Route::post('user/loginUsingOTP', 'UserController@loginUsingOTP');

