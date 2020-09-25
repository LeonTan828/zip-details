<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utilities\ZipCodeMatch;
use App\Utilities\ZipCodeAccessor;
use App\Utilities\ZipCodeDAO;

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
        $matchresult = $zipmatch->findMatch( $request->zip_code1, 
                                        $request->zip_code2, 
                                        $request->dist, 
                                        $request->distunit);

        if (gettype($matchresult) == "integer") {
            if ($matchresult == 0) {
                return view('match', [
                    'zip1' => ""
                ]);
            } 
            else if ($matchresult == 1) {
                return view('match', [
                    'zip1' => "no match"
                ]);
            }
        }

        $zip1 = $zipmatch->get($request->zip_code1);
        $zip2 = $zipmatch->get($request->zip_code2);;

        return view('match', [
            'zip1' => $zip1,
            'zip2' => $zip2
        ]);
    }
}
