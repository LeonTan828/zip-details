<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utilities\ZipCodeMatch;
use App\Utilities\ZipCodeAccessor;

class ZipMatchController extends Controller
{
    public function index()
    {
        $zip1 = "";

        return view('match', [
            'zip1' => $zip1
        ]);
    }

    public function match(Request $request)
    {
        $zipmatch = new ZipCodeMatch();
        $matchresult = $zipmatch->index( $request->zip_code1, 
                                        $request->zip_code2, 
                                        $request->dist, 
                                        $request->distunit);

        
        $zipaccess = new ZipCodeAccessor();
        $zip1 = $zipaccess->index($matchresult->zip_code1);
        $zip2 = $zipaccess->index($matchresult->zip_code2);

        return view('match', [
            'zip1' => $zip1,
            'zip2' => $zip2
        ]);
        // $resultbody = $zipaccess->index($request->zip_code);
    }
}
