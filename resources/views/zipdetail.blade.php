<!--The home page that HomeController calls-->

<!--See master.blade.php-->
@extends('master')

@section('title', 'Homepage')

@section('content')

    <div class="links">
        <a href="http://eatstreet-takehome.test/">Back to Homepage</a>
        <a href="http://eatstreet-takehome.test/matchclose">Check Zip Code Match</a>
    </div>

    <p>Please type in a zip code below and click submit</p>

    <form action="/locationdetails" method="post">
        <input type="text" name="zip_code" placeholder="Zip Code">
        {{ csrf_field() }}
        <button type="submit">Submit</button>
    </form>

    <br>
    @include('components.errormessage', ['error'=>$error])
    @foreach ($zipCodes as $zip_code)
        @include('components.table', ['zipCodes'=>array($zip_code)])
    @endforeach

@endsection