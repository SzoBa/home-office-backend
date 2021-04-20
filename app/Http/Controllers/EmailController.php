<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Dacastro4\LaravelGmail\Services\Message\Mail;


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
        $rules = [
            'address' => 'required|array',
            'address.*' => 'email:rfc,dns',
            'cc' => 'array',
            'cc.*' => 'email:rfc,dns',
            'bcc' => 'array',
            'bcc.*' => 'email:rfc:dns',
            'subject' => 'required|min:3',
            'message' => 'required|min:3'
        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return response($validation->errors()->toArray(), 400);
        }
        $mail = new Mail();
        $mail->setToken($request->user()->socialData()->where('social_type', 'google')->value('access_token'));
        $mail->to($request->get('address'));
        $mail->cc($request->get('cc', null));
        $mail->bcc($request->get('bcc', null));
        $mail->from($request->user()->email);
        $mail->subject($request->get('subject'));
        $mail->message($request->get('message'));
        $mail->send();
        return response("Mail sent", 201);
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
        \LaravelGmail::setToken($request->user()->socialData()->where('social_type', 'google')->value('access_token'));
        $mail = \LaravelGmail::message()->get($id);
//        return response($mail->getPlainTextBody(), 200);
        return response($mail->getHtmlBody(), 200);
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
