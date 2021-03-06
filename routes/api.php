<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/user', function (Request $request) {
        return $request->user();
    });


    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');
  
    Route::get('settings/user', 'UserController@index');
    Route::post('settings/createUser', 'UserController@store');
    Route::get('settings/editUser/{id}', 'UserController@edit');
    Route::post('settings/updateUser/{id}', 'UserController@updateUser');
    Route::get('settings/deleteUser/{id}', 'UserController@delete');

    Route::resource('users', 'UserController');
    
    Route::resource('companies', 'CompanyController');
    
    Route::resource('providers', 'ProviderController');
    
    Route::resource('layouts', 'LayoutController');
    Route::group(['prefix' => 'layouts/{layout}'], function () {
        Route::resource('data', 'DataController');
    });
    
    Route::resource('columns', 'ColumnController');
    
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('oauth/{provider}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{provider}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});
