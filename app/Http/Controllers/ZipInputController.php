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
            'results' => null,
            'condition' => $condition
        ]); 
    }
    
    public function find(Request $request)
    {
        $zipaccess = new ZipCodeAccessor();
        $zipaccessresult = $zipaccess->get($request->zip_code);

        return view('zipdetail', [
            'results' => $zipaccessresult['model'],
            'condition' => $zipaccessresult['error']
        ]);

        // return redirect('/');
    }
}
