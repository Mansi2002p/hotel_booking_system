<!DOCTYPE html>
<html>
<head>
    <title>Booking Confirmation</title>
</head>
<body>
    <h2>Dear {{ $booking->user->first_name }},</h2>
    <p>Your booking at <strong>{{ $booking->room->hotel->name }}</strong> has been confirmed.</p>
    <p><strong>Check-in:</strong> {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d F Y') }}</p>
    <p><strong>Check-out:</strong> {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d F Y') }}</p>
    <p>Attached is your invoice.</p>
    <p>Thank you for choosing us!</p>
</body>
</html>
