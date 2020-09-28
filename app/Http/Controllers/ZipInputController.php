<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utilities\ZipCodeAccessor;

class ZipInputController extends Controller
{
    public function index()
    {
        $model = "first";

        return view('zipdetail', [
            'results' => $model
        ]); 
    }
    
    public function find(Request $request)
    {
        $zipaccess = new ZipCodeAccessor();
        $model = $zipaccess->get($request->zip_code);

        return view('zipdetail', [
            'results' => $model
        ]);

        // return redirect('/');
    }
}
