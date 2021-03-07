<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/auth/redirect', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/auth/callback', function () {
    $user = Socialite::driver('google')->stateless()->user();
    //this is the logged in user, and ex. $user->token, etc...getId, getNickname, getName, getEmail, getAvatar,
    //OAuth2 $user->token, refreshToken, expiresIn
    //or from the token - $user = Socialite::driver('google')->userFromToken($token);
    //or $user = Socialite::driver('google')->userFromTokenAndSecret($token, $secret); - OAuth1
    //Stateless does NOT work with Twitter
});
