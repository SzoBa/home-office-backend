<?php

namespace App\Http\Controllers;

use DOMDocument;
use Illuminate\Http\Response;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        $handle = curl_init();
        $url = "http://www.correctchange.hu/en/exchange_rates";
        $headers = ['Content-Type: text/html'];
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

        preg_match('/<section id="exchange-rate-changes">(.*?)<\/div>/s', $data, $namedMatch);
        $DOM = new DOMDocument();

        libxml_use_internal_errors(true);
        $DOM->loadHTML(mb_convert_encoding($namedMatch[0], 'HTML-ENTITIES', 'UTF-8'));
        libxml_clear_errors();

        $tableContent = $DOM->getElementsByTagName('td');
        $tableHeader = ["Currency", "Currency (long)", "Buy (HUF)", "Sell (HUF)"];

        $j = 0;
        $result = [$tableHeader];
        foreach($tableContent as $index => $sNodeDetail)
        {
            $result[$j+1][] = trim($sNodeDetail->textContent);
            $j = ($index + 1) % count($tableHeader) === 0 ? $j + 1 : $j;
        }
        return response($result, 200);
    }

}