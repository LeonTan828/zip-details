<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utilities\ZipCodeMatch;

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

        $zip1 = null;
        $zip2 = null;

        if (gettype($matchresult) == "integer") {
            if ($matchresult == 0) {
                $zip1 = "";
            } 
            else if ($matchresult == 1) {
                $zip1 = "no match";
            }
        }
        else {
            $zip1 = $zipmatch->get($request->zip_code1);
            $zip2 = $zipmatch->get($request->zip_code2);
        }

        return view('match', [
            'zip1' => $zip1,
            'zip2' => $zip2
        ]);
    }
}
