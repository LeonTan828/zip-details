<!--The home page that HomeController calls-->

<!--See master.blade.php-->
@extends('master')

@section('title', 'Homepage')

@section('content')

    <p>The is a demo for an EatStreet take home assignment</p>
    <p>
        Please click on any of the link below to navigate to the page that you
        want to visit
    </p>
    <div class="links">
        <a href="http://eatstreet-takehome.test/locationdetails">Get Zip Code Details</a>
        <a href="http://eatstreet-takehome.test/matchclose">Check Zip Codes Match</a>
    </div>

@endsection