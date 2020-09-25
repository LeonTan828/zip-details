<?php

namespace App\Utilities;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ZipInput;
use App\Models\Timezone;
use App\Models\AreaCode;
use App\Models\CityName;

class ZipCodeDAO
{
    public function index($resultbody)
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

        // If timezone cannot be found, add
        if (!$this->findtime($resultbody->timezone->timezone_identifier)) {
            $timezoneInput = new Timezone();
            $timezoneInput->timezone_identifier = $resultbody->timezone->timezone_identifier;
            $timezoneInput->timezone_abbr = $resultbody->timezone->timezone_abbr;
            $timezoneInput->utc_offset_sec = $resultbody->timezone->utc_offset_sec;
            $timezoneInput->is_dst = $resultbody->timezone->is_dst;

            $timezoneInput->save();
        }

        foreach ($resultbody->acceptable_city_names as $cityname) {
            $cityInput = new CityName();
            $cityInput->city = $cityname->city;
            $cityInput->state = $cityname->state;
            $cityInput->zip_code = $resultbody->zip_code;

            $cityInput->save();
        }

        foreach ($resultbody->area_codes as $areacode) {
            $areaInput = new AreaCode();
            $areaInput->area_code = $areacode;
            $areaInput->zip_code = $resultbody->zip_code;

            $areaInput->save();
        }

        return;
    }

    public function find($zip_code)
    {
        $found = DB::table('zipinputs')->where('zip_code', $zip_code)->first();

        if (!$found) return false;
        else return true;
    }

    public function findtime($id)
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

        $cityArray = array();
        foreach ($citynames as $city) {
            $citynameobj = new AcceptableCity();
            $citynameobj->city = $city->city;
            $citynameobj->state = $city->state;

            array_push($cityArray, $citynameobj);
        }

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