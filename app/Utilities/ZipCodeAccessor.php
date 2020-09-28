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
 * Includes API calling and databse retrieval for those details
 */
class ZipCodeAccessor
{
    public function zipToLoc($zip)
    {
        $client = new Client();

        $api_key = 'fjf6y8FPeH5v2RyDScQ5FXfOQPOznHdjWUROZ4VvIlW5KWYWMiz3cUH4nRwJQqlk';
        $format = 'json';
        $units = 'degrees';
        $api_url = 'http://www.zipcodeapi.com/rest/'.$api_key.'/info.'.$format.'/'.$zip.'/'.$units;

        // Make API call
        try {
            $response = $client->request('GET', $api_url);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                // If bad request error (aka invalid input), return 0
                if ($e->getResponse()->getStatusCode() == '400') {
                    return array(
                        'model' => null,
                        'error' => 'Bad Request'
                    );
                }
                // If zip code doesn't exist, return 1
                else if ($e->getResponse()->getStatusCode() == '404') {
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

    public function get($zip_code) {

        // Check if this entry exists
        $zipDAO = new ZipCodeDAO();
        $found = $zipDAO->contains($zip_code);

        // If this zip code is not found in DB
        if (!$found) {
            echo "nothing found in db";

            // Making api call
            $apiResult = $this->zipToLoc($zip_code);

            if ($apiResult['model']) {
                $zipDAO->add($apiResult['model']);
            }
            return $apiResult;
            
        }
        // Retrieve from DB if already exist
        else {
            echo "found";
            $model = $zipDAO->get($zip_code);

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
