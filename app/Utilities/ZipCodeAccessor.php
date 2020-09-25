<?php

namespace App\Utilities;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ZipCodeAccessor
{
    public function zipToLoc($zip)
    {
        $client = new Client();

        $api_key = 'UcROKGLFeLnue77m4SgRuUHlrNYpgDl8UvOfdIWO0BTSNfoqz19zpK3w6HlLTTGC';
        $format = 'json';
        $units = 'degrees';
        $api_url = 'http://www.zipcodeapi.com/rest/'.$api_key.'/info.'.$format.'/'.$zip.'/'.$units;

        try {
            $response = $client->request('GET', $api_url);
        } catch (RequestException $e) {
            // If bad request error, return 0
            if ($e->hasResponse()) {
                if ($e->getResponse()->getStatusCode() == '400') {
                    return 0;
                }
                else if ($e->getResponse()->getStatusCode() == '404') {
                    return 1;
                }
            }
        }
        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();

        return json_decode($body);
    }
}
