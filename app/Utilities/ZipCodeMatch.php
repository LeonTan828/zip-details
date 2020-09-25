<?php

namespace App\Utilities;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Utilities\ZipCodeAccessor;
use App\Utilities\ZipCodeDAO;

class ZipCodeMatch
{
    public function findMatch($zip1, $zip2, $dist, $distunit)
    {
        $client = new Client();

        $api_key = 'UcROKGLFeLnue77m4SgRuUHlrNYpgDl8UvOfdIWO0BTSNfoqz19zpK3w6HlLTTGC';
        $format = 'json';
        $zipcodes = "".$zip1.",".$zip2;
        $api_url = 'http://www.zipcodeapi.com/rest/'.$api_key.'/match-close.'.$format.'/'.$zipcodes.'/'.$dist.'/'.$distunit;


        try {
            $response = $client->request('GET', $api_url);
        } catch (RequestException $e) {
            // If bad request error, return 0
            if ($e->hasResponse()) {
                if ($e->getResponse()->getStatusCode() >= '400') {
                    return 0;
                }
            }
        }

        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        $body = json_decode($body);

        // return 1 if no match is found
        if (sizeof($body) == 0) return 1;
        return $body[0];
    }

    public function get($zip_code)
    {
        $zipaccess = new ZipCodeAccessor();
        $zipDAO = new ZipCodeDAO();

        $found  = $zipDAO->find($zip_code);

        if (!$found) {
            echo "nothing found in db";

            // Making api call
            $zip = $zipaccess->zipToLoc($zip_code);
            
            // Store in db
            $zipDAO->add($zip);
        } else {
            echo "found";
            $zip = $zipDAO->get($zip_code);
        }

        return $zip;
    }
}
