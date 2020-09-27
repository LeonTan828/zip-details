<?php

namespace App\Utilities;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ZipInput;
use App\Models\Timezone;
use App\Models\AreaCode;
use App\Models\CityName;

/**
 * ZipCodeDAO is a class that handles access and interaction with the databse
 * 
 * ZipCodeDAO handles data entry, lookup and retrieval. Uses Eloquent and Query
 * Builder 
 */
class ZipCodeDAO
{
    public function add($resultbody)
    {
        // Store in zipinputs table
        $input = new ZipInput();
        $input->zip_code = $resultbody->zip_code;
        $input->lat = $resultbody->lat;
        $input->lng =  $resultbody->lng;
        $input->city = $resultbody->city;
        $input->state = $resultbody->state;
        $input->timezone_identifier = $resultbody->timezone->timezone_identifier;

        $input->save();

        // If timezone cannot be found, add to timezones table
        if (!$this->containsTime($resultbody->timezone->timezone_identifier)) {
            $timezoneInput = new Timezone();
            $timezoneInput->timezone_identifier = $resultbody->timezone->timezone_identifier;
            $timezoneInput->timezone_abbr = $resultbody->timezone->timezone_abbr;
            $timezoneInput->utc_offset_sec = $resultbody->timezone->utc_offset_sec;
            $timezoneInput->is_dst = $resultbody->timezone->is_dst;

            $timezoneInput->save();
        }

        // Store each acceptable city names citynames table
        foreach ($resultbody->acceptable_city_names as $cityname) {
            $cityInput = new CityName();
            $cityInput->city = $cityname->city;
            $cityInput->state = $cityname->state;
            $cityInput->zip_code = $resultbody->zip_code;

            $cityInput->save();
        }

        // Store each area codes in areacodes table
        foreach ($resultbody->area_codes as $areacode) {
            $areaInput = new AreaCode();
            $areaInput->area_code = $areacode;
            $areaInput->zip_code = $resultbody->zip_code;

            $areaInput->save();
        }

        return;
    }

    public function contains($zip_code)
    {
        $found = DB::table('zipinputs')->where('zip_code', $zip_code)->first();

        if (!$found) return false;
        else return true;
    }

    public function containsTime($id)
    {
        $found = DB::table('timezones')->where('timezone_identifier', $id)->first();

        if (!$found) return false;
        else return true;
    }

    public function get($zip_code)
    {
        $data = DB::table('zipinputs')->where('zip_code', $zip_code)->first();

        $timezone = DB::table('timezones')->where('timezone_identifier', $data->timezone_identifier)->first();
        $citynames = DB::table('citynames')->where('zip_code', $zip_code)->get();
        $areacodes = DB::table('areacodes')->where('zip_code', $zip_code)->get();

        // Make acceptable city names object
        $cityArray = array();
        foreach ($citynames as $city) {
            $citynameobj = new AcceptableCity();
            $citynameobj->city = $city->city;
            $citynameobj->state = $city->state;

            array_push($cityArray, $citynameobj);
        }

        // Make area code array
        $areacodeArray = array();
        foreach ($areacodes as $areacode) {
            array_push($areacodeArray, $areacode->area_code);
        }

        // Combining data to one model
        $data->timezone = $timezone;
        $data->acceptable_city_names = $cityArray;
        $data->area_codes = $areacodeArray;

        return $data;
    }
}

class AcceptableCity {
    public $city;
    public $state;
}