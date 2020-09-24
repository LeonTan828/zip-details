<?php

namespace App\Utilities;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ZipCodeAccessor
{
    public function index($zip)
    {
        $client = new Client();

        $api_key = 'ycu3JwgT9YdhWrpYIeyVBo6bTbxgf7D3iwAJnSmgw10Mamw5lfTXXIHHdkJHif4b';
        $format = 'json';
        $units = 'degrees';
        $api_url = 'http://www.zipcodeapi.com/rest/'.$api_key.'/info.'.$format.'/'.$zip.'/'.$units;

        $response = $client->request('GET', $api_url);

        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();

        return json_decode($body);
    }
}
