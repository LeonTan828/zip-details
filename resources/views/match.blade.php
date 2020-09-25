<!--The home page that HomeController calls-->

<!--See master.blade.php-->
@extends('master')

@section('title', 'Match Page')

@section('content')


    <p>Type in 2 zip codes below, one distance and click submit</p>

    <form action="/match" method="post">
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

    <h2>Content!</h2>

    <h3> 
    
        @if ($zip1 == "")
        <p> Please provide valid input </p>
        @elseif ($zip1 == "no match")
        <p> no match is found</p>
        @else

        <p>Zip Code:    {{ $zip1->zip_code }}
        <br>
        Latitude:       {{ $zip1->lat }}
        <br>
        Longitude:      {{ $zip1->lng }}
        <br>
        City:           {{ $zip1->city }}
        <br>
        State:          {{ $zip1->state }}
        <br>
        Timezone Identifier:    {{ $zip1->timezone->timezone_identifier }}
        <br>
        Timezone abbreviation:  {{ $zip1->timezone->timezone_abbr }}
        <br>
        UTC offset:             {{ $zip1->timezone->utc_offset_sec }}
        <br>
        is dst:                 {{ $zip1->timezone->is_dst }}
        <br>
        Acceptable city names:

            @foreach ($zip1->acceptable_city_names as $stuff)
                City: {{ $stuff->city }}
                <br>
                State: {{ $stuff->state }}
                <br>
            @endforeach

        <br>
        Area Code:
            @foreach ($zip1->area_codes as $stuff)
                {{ $stuff }}
                <br>
            @endforeach
        </p>

        <br>
        <br>

        <p>Zip Code:    {{ $zip2->zip_code }}
        <br>
        Latitude:       {{ $zip2->lat }}
        <br>
        Longitude:      {{ $zip2->lng }}
        <br>
        City:           {{ $zip2->city }}
        <br>
        State:          {{ $zip2->state }}
        <br>
        Timezone Identifier:    {{ $zip2->timezone->timezone_identifier }}
        <br>
        Timezone abbreviation:  {{ $zip2->timezone->timezone_abbr }}
        <br>
        UTC offset:             {{ $zip2->timezone->utc_offset_sec }}
        <br>
        is dst:                 {{ $zip2->timezone->is_dst }}
        <br>
        Acceptable city names:

            @foreach ($zip2->acceptable_city_names as $stuff)
                City: {{ $stuff->city }}
                <br>
                State: {{ $stuff->state }}
                <br>
            @endforeach

        <br>
        Area Code:
            @foreach ($zip2->area_codes as $stuff)
                {{ $stuff }}
                <br>
            @endforeach
        </p>
        @endif

    </h3>

@endsection