<?php

use Illuminate\Support\Facades\Route;

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/', 'InfoController@index');
    Route::get('auth/google-redirect', 'Auth\GoogleController@loginUrl');
    Route::get('auth/google-callback', 'Auth\GoogleController@loginCallback');
    Route::get('auth/github-redirect', 'Auth\GithubController@loginUrl');
    Route::get('auth/github-callback', 'Auth\GithubController@loginCallback');
    Route::post('registration/simple', 'Auth\RegistrationController@register');
    Route::post('/login', 'Auth\LoginController@login');
    Route::get('/local_weather', 'WeatherController@getWeather');
    Route::get('/forecast', 'ForecastController@index');
    Route::get('/currency', 'CurrencyController@index');
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::delete('/logout', 'Auth\LogoutController@logout');
    Route::apiResource('/mail-options', 'EmailOptionController')->except(['store', 'show', 'update', 'destroy']);
    Route::apiResource('/mail', 'EmailController');
});

