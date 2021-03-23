<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WeatherController extends Controller
{

    public function getWeather(Request $request)
    {
        /** Budapest by default */
        $latitude = $request->input("latitude", 47.497913);
        $longitude = $request->input("longitude", 19.040236);
        $weatherApiKey = env('OPENWEATHER_APIKEY');
        $weatherUrl = config('app.weatherUrl');

        $handle = curl_init();
        $url = $weatherUrl . "?lat={$latitude}&lon={$longitude}&appid={$weatherApiKey}&units=metric";
        $headers = ['Accept: application/json', 'Content-Type: application/json'];
        curl_setopt_array($handle, [
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
