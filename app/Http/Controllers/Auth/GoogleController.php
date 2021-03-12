<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SocialData;
use App\Models\User;
use Socialite;

class GoogleController extends Controller
{
    public function loginUrl()
    {
        return response([
            'url' => Socialite::driver('google')->stateless()->redirect()->getTargetUrl(),
        ]);
    }

    public function loginCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $user = null;

        \DB::transaction(function () use ($googleUser, &$user) {

            $socialData = SocialData::where(
                ['social_id' => $googleUser->getId(), 'social_type' => 'google']
            )->first();

            if (!isset($socialData)) {
                $user = User::firstOrCreate(
                    ['email' => $googleUser->getEmail(), 'name' => $googleUser->getName()]
                );

                SocialData::create(
                    ['user_id' => $user->id, 'social_id' => $googleUser->getId(),
                        'social_type' => 'google', 'social_name' => $googleUser->getName()]
                );
            } else {
                $user = $socialData->user;
            }
        });

        if (is_null($user)) {
            return response(['message' => "Database error!"], 500);
        }

        $token = $user->createToken("HomeOfficeFull");
        return response(['token' => $token->plainTextToken, 'username' => $user->name], 200);
    }
}