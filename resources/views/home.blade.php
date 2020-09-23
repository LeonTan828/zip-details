<!--The home page that HomeController calls-->

<!--See master.blade.php-->
@extends('master')

@section('title', 'Homepage')

@section('content')


    <p>Type in the zip code below and click submit</p>

    <form action="/create" method="post">
        <input type="text" name="zip_code" placeholder="Zip Code">
        {{ csrf_field() }}
        <button type="submit">Submit</button>
    </form>

    <h2>Content!</h2>

    <h3> 
        @if ($results != "")
        {{ $results->city }}
        @endif

    </h3>
    <ul>
        @foreach($usrinputs as $usrinput)
            <li>
            {{ $usrinput->zip_code }}
            
            <br>

            City - {{ $usrinput->city }}

            <br>

            State - {{ $usrinput->state }}
            
            </li>

        @endforeach
    </ul>

@endsection