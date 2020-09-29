<?php

namespace App\Utilities;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Utilities\ZipCodeDAO;
use App\Exceptions\InvalidZipCodeInputException;
use App\Exceptions\ZipCodeClientException;

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
        if(!is_numeric($zip_code) || strlen($zip_code) != 5) {
            throw new InvalidZipCodeInputException('Invalid zip code format. Zip code should consist of 5 numeric characters');
        }

    }

    public function getZipDetailAPI($zip)
    {
        $this->validateZipCodeFormat($zip);

        $client = new Client();
        $format = 'json';
        $units = 'degrees';
        $api_url = 'http://www.zipcodeapi.com/rest/'.$this->api_key.'/info.'.$format.'/'.$zip.'/'.$units;

        try {
            $response = $client->request('GET', $api_url);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                if ($e->getResponse()->getStatusCode() == '404') {
                    throw new ZipCodeClientException('This Zip code does not exist');
                }
            }
            throw new ZipCodeClientException('Caught an unknown exception: '
                .$e->getMessage(), $e->getCode(), $e);
        }

        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();

        return array(
            'details' => json_decode($body),
            'error' => null
        );
    }

    public function findZipCloseMatchAPI($zips, $dist, $distunit)
    {
        foreach ($zips as $zip) {
            $this->validateZipCodeFormat($zip);
        }
        
        $client = new Client();
        $format = 'json';
        $zipcodes = implode(',',$zips);
        $api_url = 'http://www.zipcodeapi.com/rest/'.$this->api_key.'/match-close.'.$format.'/'.$zipcodes.'/'.$dist.'/'.$distunit;

        try {
            $response = $client->request('GET', $api_url);
        } catch (RequestException $e) {
            // if ($e->hasResponse()) {
            //     if ($e->getResponse()->getStatusCode() >= '400') {
            //         return array(
            //             'matches' => null,
            //             'error' => "Bad Request"
            //         );
            //     }
            // }
            throw new ZipCodeClientException('Caught an exception: '
                .$e->getMessage(), $e->getCode(), $e);
        }

        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        $body = json_decode($body);

        return array(
            'matches' => $body,
            'error' => null
        );
    }

    public function getLocationDetails($zip_code) {

        // Check if this entry exists in DB
        $zipDAO = new ZipCodeDAO();
        $found = $zipDAO->contains($zip_code);

        // Get from API if not found in DB
        if (!$found) {
            $apiResult = $this->getZipDetailAPI($zip_code);

            if ($apiResult['details']) {
                $zipDAO->add($apiResult['details']);
                $apiResult['details']->source = 'API';
            }

            return $apiResult;
        }
        // Retrieve from DB if already exist
        else {
            $details = $zipDAO->getFromDB($zip_code);
            $details->source = 'Database';

            return array(
                'details' => $details,
                'error' => null
            );
        }
    }
}
