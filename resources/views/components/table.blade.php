

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
@foreach ($zipCodes as $zipCode)
<tr>
    <td>{{ $zipCode->zip_code }}</td>
    <td>{{ $zipCode->lat }}</td>
    <td>{{ $zipCode->lng }}</td>
    <td>{{ $zipCode->city }}</td>
    <td>{{ $zipCode->state }}</td>
    <td>{{ $zipCode->timezone->timezone_identifier }}</td>
    <td>{{ $zipCode->timezone->timezone_abbr }}</td>
    <td>{{ $zipCode->timezone->utc_offset_sec }}</td>
    <td>{{ $zipCode->timezone->is_dst }}</td>
    <td>
        @foreach ($zipCode->acceptable_city_names as $city_name)
            City: {{ $city_name->city }}
            <br>
            State: {{ $city_name->state }}
            <br>
            <br>
        @endforeach
    </td>
    <td>
        @foreach ($zipCode->area_codes as $areacode)
            {{ $areacode }}
            <br>
        @endforeach
    </td>
</tr>
@endforeach
</table>


