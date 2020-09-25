<?php

namespace App\Utilities;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Utilities\ZipCodeDAO;

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

    public function get($zip_code) {

        // Check if this entry exists
        $zipDAO = new ZipCodeDAO();
        $found = $zipDAO->find($zip_code);

        if (!$found) {
            echo "nothing found in db";

            // Making api call
            $model = $this->zipToLoc($zip_code);

            if (gettype($model) == "integer") {
                if ($model == 0) {
                    $model = "";
                }
                else if ($model == 1) {
                    $model = 'zip not found';
                } 
            }
            else {
                $zipDAO->add($model);
            }
            
        }
        else {
            echo "found";
            $model = $zipDAO->get($zip_code);
        }

        return $model;
    }
}
