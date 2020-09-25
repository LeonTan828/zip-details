<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utilities\ZipCodeAccessor;
use App\Utilities\ZipCodeDAO;

class ZipInputController extends Controller
{
    public function create(Request $request)
    {
        // Check if this entry exists
        $zipDAO = new ZipCodeDAO();
        $found = $zipDAO->find($request->zip_code);

        if (!$found) {
            echo "nothing found in db";

            // Making api call
            $zipaccess = new ZipCodeAccessor();
            $model = $zipaccess->index($request->zip_code);

            if (gettype($model) == "integer") {
                if ($model == 0) {
                    return view('home', [
                        'results' => ""
                    ]);
                }
                else if ($model == 1) {
                    return view('home', [
                        'results' => "zip not found"
                    ]);
                } 
            }
            // Store in db
            $zipDAO->index($model);
        } else {
            echo "found";
            $model = $zipDAO->get($request->zip_code);
        }

        return view('home', [
            'results' => $model
        ]);

        // return redirect('/');
    }
}
