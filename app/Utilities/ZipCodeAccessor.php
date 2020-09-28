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

    public function getZipDetailAPI($zip)
    {
        if (!$this->validateZipCodeFormat($zip)) {
            return array(
                'details' => null,
                'error' => 'Bad Request'
            );
        }

        $client = new Client();
        $format = 'json';
        $units = 'degrees';
        $api_url = 'http://www.zipcodeapi.com/rest/'.$this->api_key.'/info.'.$format.'/'.$zip.'/'.$units;

        try {
            $response = $client->request('GET', $api_url);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                if ($e->getResponse()->getStatusCode() == '404') {
                    return array(
                        'details' => null,
                        'error' => 'Zip not found'
                    );
                }
            }
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
            if (!$this->validateZipCodeFormat($zip)) {
                return array(
                    'details' => null,
                    'error' => 'Bad Request'
                );
            }
        }
        
        $client = new Client();
        $format = 'json';
        $zipcodes = implode(',',$zips);
        $api_url = 'http://www.zipcodeapi.com/rest/'.$this->api_key.'/match-close.'.$format.'/'.$zipcodes.'/'.$dist.'/'.$distunit;

        try {
            $response = $client->request('GET', $api_url);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                if ($e->getResponse()->getStatusCode() >= '400') {
                    return array(
                        'matches' => null,
                        'error' => "Bad Request"
                    );
                }
            }
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
