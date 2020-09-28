@if ($error == "Bad Request")
<div class="error-display">
    <p> Please provide valid input </p>
</div>

@elseif ($error == "Zip not found")
<div class="error-display">
    <p> This zip code does not exist </p>
</div>

@elseif ($error == "No Match")
<div class="error-display">
    <p> No Match </p>
</div>

@endif