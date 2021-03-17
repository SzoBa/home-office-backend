<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return mixed
     * @throws \JsonException
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $socialData = $user->socialData[0]; //multiple social data to one user!!!!
        $handle = curl_init();
        $url = "https://www.googleapis.com/gmail/v1/users/{$socialData->social_id}/messages";
        $headers = ['Accept: application/json', 'Content-Type: application/json',
            "Authorization: Bearer {$socialData->access_token}",
                    ];
        curl_setopt_array($handle, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => $headers,
            ]
        );
        $data = curl_exec($handle);
        curl_close($handle);
        return json_decode($data, true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws \JsonException
     */
    public function show(Request $request, int $id): Response
    {
        $user = $request->user();
        $socialData = $user->socialData[0]; //multiple social data to one user!!!!
        $handle = curl_init();
        $url = "https://www.googleapis.com/gmail/v1/users/{$socialData->social_id}/messages/{$id}";
        $headers = ['Accept: application/json', 'Content-Type: application/json',
            "Authorization: Bearer {$socialData->access_token}",
        ];
        curl_setopt_array($handle, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => $headers,
            ]
        );
        $data = curl_exec($handle);
        curl_close($handle);
        return json_decode($data, true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }


    public function mailOptions(Request $request)
    {
        $user = $request->user();
        $socialData = $user->socialData[0]; //multiple social data to one user!!!!
        $queryParams = $request->input('q');
        $handle = curl_init();
        $baseUrl = "https://www.googleapis.com/gmail/v1/users/{$socialData->social_id}/messages";
        $url = $queryParams ? $baseUrl . "?q=" . str_replace(" ", "+", $queryParams) : $baseUrl;
        $headers = ['Accept: application/json', 'Content-Type: application/json',
            "Authorization: Bearer {$socialData->access_token}",
        ];
        curl_setopt_array($handle, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => $headers,
            ]
        );
        $data = curl_exec($handle);
        curl_close($handle);
        return json_decode($data, true, 512, JSON_THROW_ON_ERROR);
    }

    public function  mailOptionsWithId(Request $request, $id) {
        return response("hali, i am not implemented yet!", 200);
    }
}
