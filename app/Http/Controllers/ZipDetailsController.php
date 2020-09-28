<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utilities\ZipCodeAccessor;

class ZipDetailsController extends Controller
{
    public function index()
    {
        $condition = "first";

        return view('zipdetail', [
            'results' => array(),
            'condition' => $condition
        ]); 
    }
    
    public function getDetails(Request $request)
    {
        $zipaccess = new ZipCodeAccessor();
        $zipaccessresult = $zipaccess->getLocationDetails($request->zip_code);

        $models = array();
        if ($zipaccessresult['model']) {
            array_push($models, $zipaccessresult['model']);
        }

        return view('zipdetail', [
            'results' => $models,
            'condition' => $zipaccessresult['error']
        ]);
    }
}
