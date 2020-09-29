<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utilities\ZipCodeAccessor;
use App\Exceptions\InvalidZipCodeInputException;

class ZipDetailsController extends Controller
{
    public function index()
    {
        return view('zipdetail', [
            'zipCodes' => array()
        ]); 

        // return back()->withError('asdfa');
    }
    
    public function getDetails(Request $request)
    {
        $zipaccess = new ZipCodeAccessor();
        $zipresult = $zipaccess->getLocationDetails($request->zip_code);

        $zipCodes = array();
        if ($zipresult) {
            array_push($zipCodes, $zipresult);
        }

        return view('zipdetail', [
            'zipCodes' => $zipCodes
        ]);
    }
}
