<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ZipInput;

class HomeController extends Controller
{
    public function index()
    {
        $results = "";

        return view('home', [
            'results' => $results
        ]);
    }
}
