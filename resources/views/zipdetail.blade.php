<!--The home page that HomeController calls-->

<!--See master.blade.php-->
@extends('master')

@section('title', 'Homepage')

@section('content')


    <p>Please type in a zip code below and click submit</p>

    <form action="/details" method="post">
        <input type="text" name="zip_code" placeholder="Zip Code">
        {{ csrf_field() }}
        <button type="submit">Submit</button>
    </form>

    <br>
    @include('components.table', ['results'=>array($results), 'condition'=>$condition])

@endsection