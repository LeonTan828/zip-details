<?php

namespace App\Utilities;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ZipCodeAccessor
{
    public function index($zip)
    {
        $client = new Client();

        $api_key = 'T2FVoIDOIkc3gIlel9Ob2JkmXZ9Z3y4LZbKeaQkcSuObj11IasF9xDM1B5QQtFUj';
        $format = 'json';
        $units = 'degrees';
        $api_url = 'http://www.zipcodeapi.com/rest/'.$api_key.'/info.'.$format.'/'.$zip.'/'.$units;

        $response = $client->request('GET', $api_url);

        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();

        return json_decode($body);
    }
}
