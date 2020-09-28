<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utilities\ZipCodeAccessor;

class ZipMatchController extends Controller
{
    public function index()
    {
        return view('match', [
            'zipCodePairs' => array(),
            'condition' => null
        ]);
    }

    public function checkMatch(Request $request)
    {
        $zipmatch = new ZipCodeAccessor();
        $zipcodes = array($request->zip_code1, $request->zip_code2);
        $matchresult = $zipmatch->findMatchAPI($zipcodes, 
                                        $request->dist, 
                                        $request->distunit);

        $zipCodePairs = array();
        $errorMessage = null;

        if ($matchresult['error']) {
            $errorMessage = $matchresult['error'];
        }
        else if (sizeof($matchresult['match']) == 0) {
            $errorMessage = 'No Match';
        }
        else {
            foreach ($matchresult['match'] as $match) {
                $zipCodePair = array($zipmatch->getLocationDetails($match->zip_code1)['model'],
                                    $zipmatch->getLocationDetails($match->zip_code2)['model']);
                
                array_push($zipCodePairs, $zipCodePair);
            }
        }

        // TODO model
        
        return view('match', [
            'zipCodePairs' => $zipCodePairs,
            'condition' => $errorMessage
        ]);
    }
}
