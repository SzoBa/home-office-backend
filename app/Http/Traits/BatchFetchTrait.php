<?php

namespace App\Http\Traits;


trait BatchFetchTrait {
    public function batchFetch($baseUrl, $accessToken, $array): array
    {
        $result = [];
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            "Authorization: Bearer {$accessToken}",
        ];

        foreach ($array as $itemId) {
            $url = $baseUrl . "/{$itemId}";
            $handle = curl_init();
            curl_setopt_array(
                $handle,
                [
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTPHEADER => $headers,
                ]
            );
            $data = curl_exec($handle);
            $result[] = json_decode($data, true, 512, JSON_THROW_ON_ERROR);
            curl_close($handle);
        }
        return $result;
    }
}