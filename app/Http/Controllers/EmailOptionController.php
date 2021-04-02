<?php

namespace App\Http\Controllers;

use App\Http\Traits\BatchFetchTrait;
use App\Http\Traits\RefreshGoggleToken;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class EmailOptionController extends Controller
{
    use BatchFetchTrait, RefreshGoggleToken;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     * @throws \JsonException
     */
    public function index(Request $request): Response
    {
        $user = $request->user();
        $test = $this->checkTokenIsExpired($user);
        $socialData = $user->socialData->where('social_type', 'google')->first();
        $queryParams = $request->input('q');
        $handle = curl_init();
        $baseUrl = config("app.gmailApiUrl") . "/{$socialData->social_id}/messages";
        $url = $queryParams ? $baseUrl . "?q=" . str_replace(" ", "+", $queryParams) : $baseUrl;
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            "Authorization: Bearer {$socialData->access_token}",
        ];
        curl_setopt_array(
            $handle,
            [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => $headers,
            ]
        );
        $data = curl_exec($handle);
        curl_close($handle);
        $jsonData = json_decode($data, true, 512, JSON_THROW_ON_ERROR);
        if (isset($jsonData->error)) {
            if ($jsonData->error->status === "UNAUTHENTICATED") {
                return \response("Login with Google to access mails!", 422);
            }
            return \response($jsonData->error->message, 400);
        }
        $data = $jsonData['messages'];
        $data = $this->batchFetch($baseUrl, $socialData->access_token, array_map(
            static function ($value) {
            return $value['id'];
        }, $data));
        return response($data, 200);
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
     * @param  int  $id
     * @return Response
     */
    public function show(Request $request, $id)
    {
        //
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
}
