<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ZipInput;

class ZipInputController extends Controller
{
    public function create(Request $request) {
        
        $input = new ZipInput();
        $input->zip_code = $request->zip_code;
        $input->lat = "0";
        $input->lng = "0";
        $input->city = "nowhere";
        $input->state = "nostate";

        $input->save();

        return redirect('/');
    }
}
