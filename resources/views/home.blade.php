<!--The home page that HomeController calls-->

<!--See master.blade.php-->
@extends('master')

@section('title', 'Homepage')

@section('content')


    <p>Type in the zip code below and click submit</p>

    <form action="/create" method="post">
        <input type="text" name="title" placeholder="Zip Code">
        <button type="submit">Submit</button>
    </form>

    <h2>Content!</h2>

    <ul>
        @foreach($usrinputs as $usrinput)
            <li>{{ $usrinput-> zip_code }} - {{ $usrinput->city }}</li>

        @endforeach
    </ul>

@endsection