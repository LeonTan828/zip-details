<?php

namespace App\Utilities;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ZipCodeAccessor
{
    public function index($zip)
    {
        $client = new Client();

        $api_key = 'A27iUnSKR0Xi8g5as2NFFWxz4W5JnVK7qeAHALfe2ZyTXaDKOYfivopeXlDYN4a6';
        $format = 'json';
        $units = 'degrees';
        $api_url = 'http://www.zipcodeapi.com/rest/'.$api_key.'/info.'.$format.'/'.$zip.'/'.$units;

        $response = $client->request('GET', $api_url);

        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();


        return json_decode($body);
    }
}
