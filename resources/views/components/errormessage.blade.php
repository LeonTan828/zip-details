@if ($condition == "first")
@elseif ($condition == "Bad Request")
<p> Please provide valid input </p>
@elseif ($condition == "Zip not found")
<p> this zip code does not exist </p>
@elseif ($condition == "No Match")
<p> No Match </p>

@endif