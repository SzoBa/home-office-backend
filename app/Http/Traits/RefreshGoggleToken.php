<?php

namespace App\Http\Traits;


use App\Models\SocialData;
use App\Models\User;
use Carbon\Carbon;

trait RefreshGoggleToken {

    public function checkTokenIsExpired(User $user): bool
    {
        $expirationTime = $user->socialData()->get('expires_at');
        $currentTime = Carbon::now();
        return $expirationTime < $currentTime;
    }


    public function refreshToken(User $user) {
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
        ];
        $clientId = env('GOOGLE_CLIENT_ID');
        $clientSecret = env('GOOGLE_CLIENT_SECRET');
        $refreshToken = $user->socialData()->get('refresh_token');
        $postData = [
            "client_id: {$clientId}",
            "client_secret: {$clientSecret}",
            "refresh_token: {$refreshToken}",
            "grant_type: refresh_token",

        ];
            $handle = curl_init();
            curl_setopt_array(
                $handle,
                [
                    CURLOPT_URL => config('app.googleTokenRefresh'),
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTPHEADER => $headers,
                    CURLOPT_POST => 1,
                    CURLOPT_POSTFIELDS => $postData,
                ]
            );
            $data = curl_exec($handle);
            curl_close($handle);
        return $data['access_token'];
    }
}