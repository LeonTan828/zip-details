<?php

namespace App\Utilities;

use Illuminate\Http\Request;
use App\Models\ZipInput;

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
        $input->timezone_id = $resultbody->timezone->timezone_identifier;
        $input->timezone_abbr = $resultbody->timezone->timezone_abbr;
        $input->utc = $resultbody->timezone->utc_offset_sec;
        $input->is_dst = $resultbody->timezone->is_dst;

        $input->save();

        return;
    }
}
