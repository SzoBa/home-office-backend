<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ForecastController extends Controller
{
    /** 5 days forecast with 3 hours intervals */
     /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function index(Request $request) {
        $latitude = $request->input("latitude", 47.497913);
        $longitude = $request->input("longitude", 19.040236);
        $weatherApiKey = env('OPENWEATHER_APIKEY');
        $forecastUrl = config('app.forecastUrl');
        $handle = curl_init();
        $url = $forecastUrl . "?lat={$latitude}&lon={$longitude}&appid={$weatherApiKey}&units=metric";
        $headers = ['Accept: application/json', 'Content-Type: application/json'];
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

}
