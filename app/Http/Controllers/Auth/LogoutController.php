<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LogoutController extends Controller
{
    /**
     * Delete user token on Logout request.
     *
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete(); //delete the current token
//        $request->user()->tokens()->delete(); delete all tokens from user
        return response(["message" => "Logout successful"], 204);
    }
}
