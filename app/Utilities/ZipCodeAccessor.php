<?php

namespace App\Utilities;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Utilities\ZipCodeDAO;

/**
 * ZipCodeAccessor is a class for getting details about location through a
 * zipcode
 * 
 * Includes API calling and database retrieval for those details
 */
class ZipCodeAccessor
{
    private $api_key = null;

    function __construct() {
        $this->api_key = env('ZIPCODEAPIKEY', '');
    }

    private function validateZipCodeFormat($zip_code) {
        return (is_numeric($zip_code) && strlen($zip_code) == 5);
    }

    // TODO getlocationdetail
    public function getDetailAPI($zip)
    {
        if (!$this->validateZipCodeFormat($zip)) {
            return array(
                'model' => null,
                'error' => 'Bad Request'
            );
        }

        $client = new Client();
        
        $format = 'json';
        $units = 'degrees';
        $api_url = 'http://www.zipcodeapi.com/rest/'.$this->api_key.'/info.'.$format.'/'.$zip.'/'.$units;

        // Make API call
        try {
            $response = $client->request('GET', $api_url);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                if ($e->getResponse()->getStatusCode() == '404') {
                    return array(
                        'model' => null,
                        'error' => 'Zip not found'
                    );
                }
            }
        }
        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();

        return array(
            'model' => json_decode($body),
            'error' => null
        );
    }

    // TODO find closest zip code pair
    public function findMatchAPI($zips, $dist, $distunit)
    {
        $client = new Client();

        $format = 'json';
        $zipcodes = implode(",",$zips);
        $api_url = 'http://www.zipcodeapi.com/rest/'.$this->api_key.'/match-close.'.$format.'/'.$zipcodes.'/'.$dist.'/'.$distunit;

        // Make API call
        try {
            $response = $client->request('GET', $api_url);
        } catch (RequestException $e) {
            // If bad request error, return 0
            if ($e->hasResponse()) {
                if ($e->getResponse()->getStatusCode() >= '400') {
                    return array(
                        'match' => null,
                        'error' => "Bad Request"
                    );
                }
            }
        }

        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        $body = json_decode($body);

        // TODO
        // return 1 if no match is found
        // if (sizeof($body) == 0) {
        //     return array(
        //         'match' => null,
        //         'error' => "No match"
        //     );
        // }
        return array(
            'match' => $body,
            'error' => null
        );
        // return $body[0];
    }

    public function getLocationDetails($zip_code) {

        // Check if this entry exists in DB
        $zipDAO = new ZipCodeDAO();
        $found = $zipDAO->contains($zip_code);

        // If this zip code is not found in DB
        if (!$found) {
            echo "nothing found in db";

            // Making api call
            $apiResult = $this->getDetailAPI($zip_code);

            if ($apiResult['model']) {
                $zipDAO->add($apiResult['model']);
            }
            return $apiResult;
            
        }
        // Retrieve from DB if already exist
        else {
            echo "found";
            $model = $zipDAO->getFromDB($zip_code);

            return array(
                "model" => $model,
                "error" => null
            );
        }

        // return array(
        //     "model" => $model,
        //     "error" => $error
        // );
    }
}
