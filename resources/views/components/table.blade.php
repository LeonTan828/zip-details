@if ($condition == "first")
@elseif ($condition == "Bad Request")
<p> Please provide valid input </p>
@elseif ($condition == "Zip not found")
<p> this zip code does not exist </p>
@else

<h2>Details</h2>

<table>
<tr>
    <th>Zip Code</th>
    <th>Latitude</th>
    <th>Longitude</th>
    <th>City</th>
    <th>State</th>
    <th>Timezone<br>Identifier</th>
    <th>Timezone<br>Abbreviation</th>
    <th>UTC<br>Offset</th>
    <th>Daylight<br>Saving</th>
    <th>Acceptable<br>City Names</th>
    <th>Area<br>Codes</th>
</tr>
@foreach ($results as $result)
<tr>
    <td>{{ $result->zip_code }}</td>
    <td>{{ $result->lat }}</td>
    <td>{{ $result->lng }}</td>
    <td>{{ $result->city }}</td>
    <td>{{ $result->state }}</td>
    <td>{{ $result->timezone->timezone_identifier }}</td>
    <td>{{ $result->timezone->timezone_abbr }}</td>
    <td>{{ $result->timezone->utc_offset_sec }}</td>
    <td>{{ $result->timezone->is_dst }}</td>
    <td>
        @foreach ($result->acceptable_city_names as $city_name)
            City: {{ $city_name->city }}
            <br>
            State: {{ $city_name->state }}
            <br>
            <br>
        @endforeach
    </td>
    <td>
        @foreach ($result->area_codes as $areacode)
            {{ $areacode }}
            <br>
        @endforeach
    </td>
</tr>
@endforeach
</table>


@endif
