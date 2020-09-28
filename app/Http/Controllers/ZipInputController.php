<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utilities\ZipCodeAccessor;

class ZipInputController extends Controller
{
    public function index()
    {
        $condition = "first";

        return view('zipdetail', [
            'results' => array(),
            'condition' => $condition
        ]); 
    }
    
    public function find(Request $request)
    {
        $zipaccess = new ZipCodeAccessor();
        $zipaccessresult = $zipaccess->get($request->zip_code);

        $models = array();
        if ($zipaccessresult['model']) {
            array_push($models, $zipaccessresult['model']);
        }

        return view('zipdetail', [
            'results' => $models,
            'condition' => $zipaccessresult['error']
        ]);

        // return redirect('/');
    }
}
