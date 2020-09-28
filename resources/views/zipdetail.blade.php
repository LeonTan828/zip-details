<!--The home page that HomeController calls-->

<!--See master.blade.php-->
@extends('master')

@section('title', 'Homepage')

@section('content')

    <div class="links">
        <a href="http://eatstreet-takehome.test/">Back to Homepage</a>
        <a href="http://eatstreet-takehome.test/match">Check Zip Code Match</a>
    </div>

    <p>Please type in a zip code below and click submit</p>

    <form action="/details" method="post">
        <input type="text" name="zip_code" placeholder="Zip Code">
        {{ csrf_field() }}
        <button type="submit">Submit</button>
    </form>

    <br>
    @include('components.errormessage', ['condition'=>$condition])
    @foreach ($results as $result)
        @include('components.table', ['zipCodes'=>array($result)])
    @endforeach

@endsection