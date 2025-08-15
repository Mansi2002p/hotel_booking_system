<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Created/Updated</title>
</head>
<body>
    <h1>Hotel Details</h1>
    <p><strong>Name:</strong> {{ $hotelName }}</p>
    <p><strong>Address:</strong> {{ $hotelAddress }}</p>
    <p><strong>City:</strong> {{ $hotelCity }}</p>
    <h2>Submitted By</h2>
    <p><strong>User Name:</strong> {{ $userName }}</p>
    <h2>Message</h2>
    <p>The Hotel Register by {{ $userName }}</p>
 
</body>
</html>
