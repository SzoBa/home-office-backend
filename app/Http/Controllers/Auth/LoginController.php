<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    /**
     * Validate and check user information in database.
     * Validation approved -> create token for user.
     * Validation failed -> return error message.
     *
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function login(Request $request) {
        $rules = [
            'email' => 'required|string|email|max:255|exists:users,email',
            'password' => 'required|string|min:3',
        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return response($validation->errors(), 422);
        }
        $credentials = $request->only(['email', 'password']);
        if(auth()->attempt($credentials)) {
            $token = $request->user()->createToken("HomeOfficeFull");
            return response(['token' => $token->plainTextToken, 'username' => $request->user()->name], 201);
        }
        return response(['message' => ['Wrong login data!']], 401);
    }

}
