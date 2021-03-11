<?php

use Illuminate\Support\Facades\Route;

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::group(['scheme' => 'https'], function () {
    Route::get('/auth/google-redirect', function () {
        return Socialite::driver('google')->stateless()->redirect();
    });

    Route::get('/auth/google-callback', function () {
        $user = Socialite::driver('google')->stateless()->user();
        /** cookie here */
        $name = 'Test Elek';
        Cookie::queue($name);
        return redirect('http://localhost:3000');
    });
});


Route::group(['middleware' => 'guest'], function () {
    Route::post('registration/simple', 'Auth\RegistrationController@register');
    Route::post('/login', 'Auth\LoginController@login');
});


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::delete('/logout', 'Auth\LogoutController@logout');
    Route::apiResource('/mail', 'EmailController');
});
