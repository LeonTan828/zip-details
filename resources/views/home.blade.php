<!--The home page that HomeController calls-->

<!--See master.blade.php-->
@extends('master')

@section('title', 'Homepage')

@section('content')

    <div class="links">
        <a href="http://eatstreet-takehome.test/details">try </a>
    </div>

    <p>Type in the zip code below and click submit</p>

    <form action="/details" method="get">
        {{ csrf_field() }}
        <button type="submit">Find Zip Code Details</button>
    </form>

    <br>

    <form action="/match" method="get">
        {{ csrf_field() }}
        <button type="submit">Go to Zip Code Matching</button>
    </form>



@endsection