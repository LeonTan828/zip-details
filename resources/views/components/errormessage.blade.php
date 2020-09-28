@if ($error == "Bad Request")
<p> Please provide valid input </p>
@elseif ($error == "Zip not found")
<p> This zip code does not exist </p>
@elseif ($error == "No Match")
<p> No Match </p>

@endif