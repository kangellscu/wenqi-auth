<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'aaa'], function () {
    Route::get('login', 'AuthController@showLoginForm')->name('admin.login');
    Route::post('login', 'AuthController@login');
    Route::get('logout', 'AuthController@logout');

    Route::get('password-changing', 'AuthController@passwordChangingPage');
    Route::post('password-changing', 'AuthController@passwordChanging');
});

Route::group(['middleware' => 'auth:admin'], function () {
    Route::get('clients', 'ClientController@clientList');
    Route::put('clients', 'ClientController@createNewClient');
    Route::get('client/{id}', 'ClientController@client');
    Route::post('client/{id}', 'ClientController@editClient');
    Route::put('client/{id}/auths', 'ClientController@authClient');
});
