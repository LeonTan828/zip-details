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

        <p>Zip Code:    {{ $results->zip_code }}
        <br>
        Latitude:       {{ $results->lat }}
        <br>
        Longitude:      {{ $results->lng }}
        <br>
        City:           {{ $results->city }}
        <br>
        State:          {{ $results->state }}
        <br>
        Timezone Identifier:    {{ $results->timezone->timezone_identifier }}
        <br>
        Timezone abbreviation:  {{ $results->timezone->timezone_abbr }}
        <br>
        UTC offset:             {{ $results->timezone->utc_offset_sec }}
        <br>
        is dst:                 {{ $results->timezone->is_dst }}
        <br>
        Acceptable city names:

            @foreach ($results->acceptable_city_names as $stuff)
                {{ $stuff }}
                <br>
            @endforeach

        <br>
        Area Code:
            @foreach ($results->area_codes as $stuff)
                {{ $stuff }}
                <br>
            @endforeach
        </p>
        @endif

    </h3>

@endsection