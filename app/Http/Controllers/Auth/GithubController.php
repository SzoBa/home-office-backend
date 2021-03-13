<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SocialData;
use App\Models\User;
use Socialite;

class GithubController extends Controller
{
    public function loginUrl()
    {
        return response([
            'url' => Socialite::driver('github')->stateless()->redirect()->getTargetUrl(),
        ]);
    }

    public function loginCallback()
    {
        $githubUser = Socialite::driver('github')->stateless()->user();
        $user = null;

        \DB::transaction(function () use ($githubUser, &$user) {

            $socialData = SocialData::where(
                ['social_id' => $githubUser->getId(), 'social_type' => 'github']
            )->first();

            if (!isset($socialData)) {
                $user = User::firstOrCreate(
                    ['email' => $githubUser->getEmail()],
                    ['name' => $githubUser->nickname]
                );

                SocialData::create(
                    ['user_id' => $user->id, 'social_id' => $githubUser->getId(),
                        'social_type' => 'github', 'social_name' => $githubUser->nickname]
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
