<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

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
        $socialData = $user->socialData->where('social_type', 'google')->first();
        $handle = curl_init();
        $url = config("app.gmailApiUrl") . "/{$socialData->social_id}/messages";
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
        return response($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        $rules = ['name' =>'required',
            'subject' => 'required|min:3', 'message' => 'required|min:3'];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return response($validation->errors(), 400);
        }
        //TODO here comes the GMAIL apiClient stuff
        return response('email sent!:D', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param string $id
     * @return Response
     */
    public function show(Request $request, string $id): Response
    {
        //TODO change this for GMAIL apiClient stuff get email object functionality
        $user = $request->user();
        $socialData = $user->socialData->where('social_type', 'google')->first();
        $handle = curl_init();
        $url = config("app.gmailApiUrl") . "/{$socialData->social_id}/messages/{$id}";
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
        return response($data, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
