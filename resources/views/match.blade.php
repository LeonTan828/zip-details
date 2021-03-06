<!--The home page that HomeController calls-->

<!--See master.blade.php-->
@extends('master')

@section('title', 'Match Page')

@section('content')

    <div class="links">
        <a href="http://eatstreet-takehome.test/">Back to Homepage</a>
        <a href="http://eatstreet-takehome.test/locationdetails">Check Zip Code Details</a>
    </div>
    
    <p>Type in 2 zip codes below, one distance and click submit</p>

    <form action="/matchclose" method="post">
        <input type="text" name="zip_code1" placeholder="Zip Code">
        <input type="text" name="zip_code2" placeholder="Zip Code">
        <input type="text" name="dist" placeholder="Distance">
        <br>
        <input type="radio" id="km" name="distunit" value="km">
        <label for="km">km</label><br>
        <input type="radio" id="mile" name="distunit" value="mile" checked>
        <label for="mile">mile</label><br>
        {{ csrf_field() }}
        <button type="submit">Submit</button>
    </form>

    @if (Session('error'))
        <p class="alert alert-danger">{{ session('error') }}</p>
    @endif
    @if (sizeof($zipCodePairs) == 0 && !$landing)
        <p class="alert"> No Match <p>
    @endif
    @foreach ($zipCodePairs as $pair)
        @include('components.table', ['zipCodes' => $pair])
        <br>
    @endforeach
    
@endsection