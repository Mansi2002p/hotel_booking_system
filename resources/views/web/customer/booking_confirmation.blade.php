@extends('web.layouts.app')

@section('title', 'Booking Confirmation')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    li {
        list-style: none;
    }
    .booking-card {
        border: 1px solid #ddd;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 8px;
        background: #f9f9f9;
    }


</style>

<div class="container">
    <h2>My Booking</h2>

    @if($bookings->isEmpty())
        <p>No bookings found.</p>
    @else
        <p>Thank you! Here are your all bookings</p>

        <div class="row">
            @foreach($bookings as $booking)
                <div class="col-md-3 mb-4"> <!-- 4 cards in a row -->
                    <div class="booking-card">
                        <ul>
                            @if($booking->status === 'confirm')
                            <a href="{{ route('booking.invoice', $booking->id) }}" 
                               class="btn btn-danger btn-sm mt-2 download-pdf"
                               data-bs-toggle="tooltip"
                               data-bs-placement="top"
                               title="Invoice Download ">
                               <i class="bi bi-cloud-arrow-down-fill"></i>
                            </a>
                        @endif
                        

                            <li class="mt-3"><strong>Hotel Name :</strong> {{ $booking->room->hotel->name }}</li>
                            <li><strong>Room Type:</strong> {{ $booking->room->roomtype->name }}</li>
                            <li><strong>Guests:</strong> {{ $booking->guests }}</li>
                            <li><strong>Check-in:</strong> {{ $booking->check_in_date }}</li>
                            <li><strong>Check-out:</strong> {{ $booking->check_in_out }}</li>
                            <li><strong>Total Price:</strong> ₹{{ $booking->total_price }}</li>
                            <li><strong>Payment Status:</strong> {{ ucfirst($booking->status) }}</li>
                            
                           
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center mt-3">
            {!! $bookings->links('pagination::bootstrap-4') !!}
        </div>
    @endif
</div>

@endsection
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
