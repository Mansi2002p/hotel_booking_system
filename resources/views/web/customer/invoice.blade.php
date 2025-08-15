<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 10px; }
        .container { width: 700px; margin: 0 auto; padding: 10px; border: 1px solid #ddd; }
        .header { text-align: left; }
        .header h1 { font-size: 32px; color: #2a3f75;  }
        .info { display: flex; justify-content: space-between; }
        .section { margin: 20px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #2a3f75; color: white; }
        .total-section { text-align: right; margin-top: 20px; font-size: 18px; font-weight: 300; }
        .footer { text-align: center; margin-top: 30px; font-size: 14px; color: #555; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="text-center">INVOICE</h1>
            <div class="info">
                <div>
                    <p><strong>{{ $booking->room->hotel->name }}</strong></p>
                    <p>{{ $booking->room->hotel->address }}</p>
                    <p>{{ $booking->room->hotel->Phoneno }} | {{ $booking->room->hotel->email }}</p>
                    <p><a href="">{{ $booking->room->hotel->website }}</a></p>
                </div>
                <div>
                    <p><strong>Invoice No:</strong>{{ $booking->id }}</p>
                    {{-- <p><strong>Account No:</strong> 0002234</p> --}}
                    <p><strong>Check-in:</strong>{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d-F-Y') }}
                    </p>
                    <p><strong>Check-out:</strong> {{ \Carbon\Carbon::parse($booking->check_in_out)->format('d-F-Y') }}</p>
                </div>
            </div>
        </div>

        <div class="section">
            <p><strong>Customer Detail:</strong></p>
            <p>{{ $booking->user->first_name }}</p>
            <p>{{ $booking->user->email }} | {{ $booking->user->moblieno }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Room Type</th>
                    <th>Rooms </th>
                    <th>Room Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $booking->room->roomtype->name }}</td>
                    <td>{{ ($booking->rooms) }}</td>
                    <td>{{ number_format($booking->room->price, 2) }}</td>
                    <td>{{ number_format($booking->hotel_charges, 2) }}</td>
                </tr>
               
            </tbody>
        </table>

        <div class="total-section">
            <p> <strong>Hotel Charges:</strong> {{  number_format($booking->hotel_charges ,2) }}</p>
            <p>Discount: {{  number_format($booking->discount ,2) }}</p>
            <hr>
            <p> <strong>SubTotal: </strong>{{  number_format($booking->sub_total,2) }}</p>
            <p>Tax: {{  number_format($booking->taxes,2) }}</p>
            <p> <strong>Service Charges: </strong>{{  number_format($booking->service_charge , 2) }}</p>
           
            <hr>
            <p> <strong>Total Price: </strong>{{  number_format($booking->total_price ,2) }}</p>
        </div>

        <div class="footer">
            <p>Thank you</p>   
            {{-- <p><strong>Your Company Name - Company MD</strong></p> --}}
        </div>
    </div>
</body>
</html>

