<?php

namespace App\Utilities;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ZipCodeMatch
{
    public function index($zip1, $zip2, $dist, $distunit)
    {
        $client = new Client();

        $api_key = 'ycu3JwgT9YdhWrpYIeyVBo6bTbxgf7D3iwAJnSmgw10Mamw5lfTXXIHHdkJHif4b';
        $format = 'json';
        $zipcodes = "".$zip1.",".$zip2;
        $api_url = 'http://www.zipcodeapi.com/rest/'.$api_key.'/match-close.'.$format.'/'.$zipcodes.'/'.$dist.'/'.$distunit;

        $response = $client->request('GET', $api_url);

        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();

        return json_decode($body)[0];
    }
}
