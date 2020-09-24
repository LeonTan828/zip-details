<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ZipInput;
// use GuzzleHttp\Client;
use App\Utilities\ZipCodeAccessor;
use App\Utilities\ZipCodeDAO;


class ZipInputController extends Controller
{
    public function create(Request $request) {
        
        // Making api call
        $zipaccess = new ZipCodeAccessor();
        $resultbody = $zipaccess->index($request->zip_code);

        // Store in db
        $zipstore = new ZipCodeDAO();
        $zipstore->index($resultbody);

        return view('home', [
            'results' => $resultbody
        ]);

        // return redirect('/');
    }
}
