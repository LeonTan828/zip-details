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

        $zipaccess = new ZipCodeAccessor();
        $zipDAO = new ZipCodeDAO();
        $found1 = $zipDAO->find($request->zip_code1);
        $found2 = $zipDAO->find($request->zip_code2);
        $zip1 = "";
        $zip2 = "";

        if (!$found1) {
            echo "nothing found in db";

            // Making api call
            $zip1 = $zipaccess->zipToLoc($request->zip_code1);
            
            // Store in db
            $zipDAO->add($zip1);
        } else {
            echo "found";
            $zip1 = $zipDAO->get($request->zip_code1);
        }

        if (!$found2) {
            echo "nothing found in db";

            // Making api call
            $zip2 = $zipaccess->zipToLoc($request->zip_code2);

            // Store in db
            $zipDAO->add($zip2);
        } else {
            echo "found";
            $zip2 = $zipDAO->get($request->zip_code2);
        }

        return view('match', [
            'zip1' => $zip1,
            'zip2' => $zip2
        ]);
    }
}
