<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ZipInput;
// use GuzzleHttp\Client;
use App\Utilities\ZipCodeAccessor;


class ZipInputController extends Controller
{
    public function create(Request $request) {
        

        $zipaccess = new ZipCodeAccessor();

        $input = new ZipInput();
        $input->zip_code = $request->zip_code;
        $input->lat = "0";
        $input->lng = "0";
        $input->city = "nowhere";
        $input->state = "nostate";

        $input->save();

        $inputs = ZipInput::all();

        return view('home', [
            'usrinputs' => $inputs,
            'results' => $zipaccess->index($request->zip_code)
        ]);

        // return redirect('/');
    }
}
