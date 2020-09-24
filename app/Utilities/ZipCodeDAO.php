<?php

namespace App\Utilities;

use Illuminate\Http\Request;
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

        $timezoneInput = new Timezone();
        $timezoneInput->timezone_identifier = $resultbody->timezone->timezone_identifier;
        $timezoneInput->timezone_abbr = $resultbody->timezone->timezone_abbr;
        $timezoneInput->utc_offset_sec = $resultbody->timezone->utc_offset_sec;
        $timezoneInput->is_dst = $resultbody->timezone->is_dst;

        
        

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

        $timezoneInput->save();
        $input->save();

        return;
    }
}
