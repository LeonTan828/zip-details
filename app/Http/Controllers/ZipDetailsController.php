<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utilities\ZipCodeAccessor;

class ZipDetailsController extends Controller
{
    public function index()
    {
        return view('zipdetail', [
            'zipCodes' => array(),
            'error' => null
        ]); 
    }
    
    public function getDetails(Request $request)
    {
        $zipaccess = new ZipCodeAccessor();
        $zipresult = $zipaccess->getLocationDetails($request->zip_code);

        $details = array();
        if ($zipresult['details']) {
            array_push($details, $zipresult['details']);
        }

        return view('zipdetail', [
            'zipCodes' => $details,
            'error' => $zipresult['error']
        ]);
    }
}
