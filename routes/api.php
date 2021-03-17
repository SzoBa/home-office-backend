<?php

use Illuminate\Support\Facades\Route;

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['middleware' => 'guest'], function () {
    Route::get('auth/google-redirect', 'Auth\GoogleController@loginUrl');
    Route::get('auth/google-callback', 'Auth\GoogleController@loginCallback');
    Route::get('auth/github-redirect', 'Auth\GithubController@loginUrl');
    Route::get('auth/github-callback', 'Auth\GithubController@loginCallback');
    Route::post('registration/simple', 'Auth\RegistrationController@register');
    Route::post('/login', 'Auth\LoginController@login');
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::delete('/logout', 'Auth\LogoutController@logout');
    Route::get('/mail/options', 'EmailController@mailOptions');
    Route::get('/mail/options/{id}', 'EmailController@mailOptionsWithId');
    Route::apiResource('/mail', 'EmailController');
});
