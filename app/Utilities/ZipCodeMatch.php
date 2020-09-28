<?php

namespace App\Utilities;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Utilities\ZipCodeAccessor;
use App\Utilities\ZipCodeDAO;

/**
 * A class for handling matching zip codes and retrieval of location details for
 * those zip codes
 * 
 * Mainly called by ZipMatchController
 * 
 * Involves API calls and database retrieval
 */
class ZipCodeMatch
{
    public function findMatch($zip1, $zip2, $dist, $distunit)
    {
        $client = new Client();

        $api_key = 'fjf6y8FPeH5v2RyDScQ5FXfOQPOznHdjWUROZ4VvIlW5KWYWMiz3cUH4nRwJQqlk';
        $format = 'json';
        $zipcodes = "".$zip1.",".$zip2;
        $api_url = 'http://www.zipcodeapi.com/rest/'.$api_key.'/match-close.'.$format.'/'.$zipcodes.'/'.$dist.'/'.$distunit;

        // Make API call
        try {
            $response = $client->request('GET', $api_url);
        } catch (RequestException $e) {
            // If bad request error, return 0
            if ($e->hasResponse()) {
                if ($e->getResponse()->getStatusCode() >= '400') {
                    return "Bad Request";
                }
            }
        }

        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        $body = json_decode($body);

        // return 1 if no match is found
        if (sizeof($body) == 0) {
            return "No match";
        }
        return "Match found";
        // return $body[0];
    }

    public function get($zip_code)
    {
        $zipaccess = new ZipCodeAccessor();
        $zipDAO = new ZipCodeDAO();

        $found  = $zipDAO->contains($zip_code);

        if (!$found) {
            echo "nothing found in db";

            // Making api call
            $zip = $zipaccess->zipToLoc($zip_code);
            
            // Store in DB
            $zipDAO->add($zip);
        }
        // If found, get from DB
        else {
            echo "found";
            $zip = $zipDAO->get($zip_code);
        }

        return $zip;
    }
}
