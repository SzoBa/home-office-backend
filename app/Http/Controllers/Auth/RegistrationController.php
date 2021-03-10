<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    /**
     * Store a newly created user with email, name, and password.
     *
     * @param Request $request
     * @return Response
     * Returns newly registered user information.
     */
    public function register(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:3|max:20', //password_confirmation 4th param req. from frontend
        ]);

        if($validator->fails()){
            return response($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password'))]);

        return response([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }
}
