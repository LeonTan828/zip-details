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
            'error' => null
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
        $errorMessage = null;

        if ($matchresult['error']) {
            $errorMessage = $matchresult['error'];
        }
        else if (sizeof($matchresult['matches']) == 0) {
            $errorMessage = 'No Match';
        }
        else {
            foreach ($matchresult['matches'] as $match) {
                $zipCodePair = array($zipmatch->getLocationDetails($match->zip_code1)['details'],
                                    $zipmatch->getLocationDetails($match->zip_code2)['details']);
                
                array_push($zipCodePairs, $zipCodePair);
            }
        }
        
        return view('match', [
            'zipCodePairs' => $zipCodePairs,
            'error' => $errorMessage
        ]);
    }
}
