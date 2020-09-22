<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ZipInput;

class HomeController extends Controller
{
    public function index()
    {
        $inputs = ZipInput::all();

        return view('home', [
            'usrinputs' => $inputs
        ]);
    }
}
