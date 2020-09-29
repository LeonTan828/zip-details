<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utilities\ZipCodeAccessor;

class ZipMatchController extends Controller
{
    public function index()
    {
        return view('match', [
            'zipCodePairs' => array()
        ]);
    }

    public function checkMatch(Request $request)
    {
        $zipmatch = new ZipCodeAccessor();
        $zipcodes = array($request->zip_code1, $request->zip_code2);
        $matchresult = $zipmatch->findZipCloseMatchAPI($zipcodes, 
                                        $request->dist, 
                                        $request->distunit);

        $zipCodePairs = array();

        foreach ($matchresult as $match) {
            $zipCodePair = array($zipmatch->getLocationDetails($match->zip_code1),
                                $zipmatch->getLocationDetails($match->zip_code2));
            
            array_push($zipCodePairs, $zipCodePair);
        }
        
        return view('match', [
            'zipCodePairs' => $zipCodePairs
        ]);
    }
}
