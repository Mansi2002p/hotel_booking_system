@extends('web.layouts.app')

@section('title', ' - Hotel Details')

@section('content')


<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <h3 class="mt-3 text-center"> Booking Details</h3>
                <div class="card-header">
              
                    <h4>{{ $booking->room->hotel->name }} <span class="stars"></span></h4>
                    <p>{{ $booking->room->hotel->address }}</p>

                    {{-- <img src="{{ $hotel && $hotel->getFirstMediaUrl('images') ? $hotel->getFirstMediaUrl('images') : asset('imges/hotel.jpg') }}" alt="Hotel Image" class="img-fluid"> --}}

                </div>
                <div class="card-body">
                    <div class="booking-details">
                        <p><strong>Check-in:</strong> {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y h:i A') }}</p>
                        <p><strong>Check-out:</strong> {{ \Carbon\Carbon::parse($booking->check_in_out)->format('d M Y h:i A') }}</p>
                        <p><strong>Room Type:</strong> {{ $booking->room->roomtype->name }}</p>
                        <p><strong>Guests:</strong> {{ $booking->guests }}</p>
                    </div>

                 
                    

                    <div class="payment-details">
                        <p><strong>Cancellation Policy:</strong> Free cancellation before {{ \Carbon\Carbon::parse($booking->check_in_date)->subDay()->format('d M Y') }}</p>
                    </div>
                    {{-- <button type="button" class="btn btn-danger" id="cancelBookingButton">Cancel Booking</button> --}}
                    <button type="button" class="btn btn-danger" id="cancelBookingButton" data-booking-id="{{ $booking->id }}">
                        Cancel Booking
                    </button>
                    

                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Price Breakup</h5>
                </div>
                <div class="card-body">
                 
                        {{-- <p><strong>Room Charges:</strong> </p> --}}
                        <div class="summary-item d-flex justify-content-between">
                            <span>Room Charges</span>
                            <span>₹{{ number_format($booking->total_price, 2) }}</span>
                        </div>
                        {{-- <div class="summary-item d-flex justify-content-between text-muted">
                            <span>Hotel Taxes:</span>
                            <span id="taxes"> ₹{{ number_format($booking->taxes, 2) }}</span>
                        </div> --}}
                 

                        <div class="price-breakup">
                            <hr>
                            <div class="summary-item d-flex justify-content-between text-dark fw-bold fs-4">
                                <span>Total Amount :</span>
                                <span id="total-price">₹{{ number_format($booking->total_price, 2) }}</span>
                            </div>
                        </div>

                     
                </div>
            </div>

            <div class="card mt-5 ">
                <div class="card-header">
                    <h5>Payment </h5>
                </div>
                <br>
                <div class="card-body">
                    {{-- <a href="{{route('customer.payment',['booking' => $booking->id])}}" class="btn  text-center" style="background-color: #dfa974; color: #fff; margin-left: 150px;">Pay now</a> --}}
                    <a href="{{ route('customer.payment', ['bookingId' => $booking->id]) }}" class="btn text-center" style="background-color: #dfa974; color: #fff; margin-left: 150px;">Pay now</a>

                </div>
            </div>
        </div>
       
    </div>
</div>
<br>


@push('styles')
<style>
    .stars {
        color: gold;
    }
    .price-breakup, .payment-details {
        margin-top: 20px;
    }
    .actions {
        margin-top: 20px;
    }
</style>
@endpush



<script>
//  cancel booking
// $(document).ready(function() {
//     $('#cancelBookingButton').click(function() {
//         var bookingId = $id;  // Replace with the actual booking ID you want to cancel

//         $.ajax({
//             url: '{{ route('cancel-booking') }}',  // Use named route for clarity
//             method: 'POST',
//             data: {
//                 id: bookingId,
//                 _token: '{{ csrf_token() }}'  // Include CSRF token for security
//             },
//             success: function(response) {
//                 if (response.success) {
//                     // Use SweetAlert2 to show a success message
//                     Swal.fire({
//                         icon: 'success',
//                         title: 'Success!',
//                         text: response.message,  // Show the success message
//                         confirmButtonText: 'OK'
//                     });

//                     // Update the UI, e.g., disable the cancel button and change its text
//                     $('#cancelBookingButton').text('Canceled').attr('disabled', true);
//                 } else {
//                     // Show an error message using SweetAlert2
//                     Swal.fire({
//                         icon: 'error',
//                         title: 'Error!',
//                         text: response.message,  // Show the error message
//                         confirmButtonText: 'OK'
//                     });
//                 }
//             },
//             error: function(xhr, status, error) {
//                 // Handle errors (e.g., server issues)
//                 Swal.fire({
//                     icon: 'error',
//                     title: 'Something went wrong',
//                     text: 'Please try again.',
//                     confirmButtonText: 'OK'
//                 });
//             }
//         });
//     });
// });


$(document).ready(function() {
    $('#cancelBookingButton').click(function() {
        var bookingId = $(this).data('booking-id'); // Get booking ID from button data attribute

        $.ajax({
            url: '{{ route('cancel-booking') }}',
            method: 'POST',
            data: {
                id: bookingId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    // Use SweetAlert2 for success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        confirmButtonText: 'OK'
                    });

                    // Update the button text and disable it
                    $('#cancelBookingButton').text('Canceled').attr('disabled', true);

                    // Update the URL without reloading the page
                    window.history.pushState({}, '', '/customer/booking/details/' + bookingId);
                } else {
                    // Show an error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message,
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr, status, error) {
                // Handle errors
                Swal.fire({
                    icon: 'error',
                    title: 'Something went wrong',
                    text: 'Please try again.',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
});


</script>


@endsection




