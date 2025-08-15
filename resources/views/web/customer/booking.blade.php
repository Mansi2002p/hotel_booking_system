@extends('web.layouts.app')

@section('title', ' - Hotel Details')

@section('content')
<div class="row">
  
    <div class="col-xl-4 col-lg-5 offset-xl-2 offset-lg-1" style="border:1px solid #ebebeb;">
        <br>
          {{--  room selected that details --}}
        <div class="col-lg-4 col-lg-12  p-3" style="border:1px solid #ebebeb; background: #fff;  border-radius: 10px;">
            <div id="room-details" class="mt-3">
                @if($selectedRoom)
                    <h4>Room Details</h4>
                    @if($selectedRoom->hasMedia('room_images'))
                        <img src="{{ $selectedRoom->getFirstMediaUrl('room_images', 'thumb') }}" alt="Room Image">
                    @else
                        <p>No image available for this room.</p>
                    @endif
                    <input type="hidden" id="selected_room_id" name="room_id" value="{{ $selectedRoom->id }}">
                    <p><strong>Room Type:</strong> {{ $selectedRoom->roomType->name }}</p>
                    <p><strong>Bed:</strong> Max person {{ $selectedRoom->bed_capacity }}</p>
                    <p><strong>Air Conditon:</strong>  {{ $selectedRoom->air_conditon }}</p>
                    <p><strong>Price per Night:</strong> ₹{{ $selectedRoom->price }}</p>
                    <p><strong>Services:</strong> {{ $selectedRoom->amenities->pluck('name')->take(2)->implode(' , ') }} </p>
                @else
                    <p>Please select a room to see details.</p>
                @endif
            </div>
        </div>
{{-- Total charges  --}}
        <div style="border:1px solid #ebebeb; background: #fff; border-radius: 10px; padding:10px ; margin-top:10px">
            <input type="hidden" id="room_id" name="room_id" value="{{ $rooms->first()->id }}">
            <h3>Price Details:</h3>
            <hr>
            <div class="summary-item d-flex justify-content-between">
                <span>Hotel Charges</span>
                <span id="hotel-charges">₹0</span>
            </div>
            <div class="summary-item d-flex justify-content-between text-success fw-semibold">
                <span>Discounts</span>
                <span id="discount">- ₹0</span>
            </div>
            <hr>
            <div class="summary-item d-flex justify-content-between fw-bold fs-5">
                <span>Sub Total</span>
                <span id="sub-total">₹0</span>
            </div>
            <div class="summary-item d-flex justify-content-between text-muted">
                <span>Taxes & Charges</span>
                <span id="taxes">₹0</span>
            </div>
            <div class="summary-item d-flex justify-content-between text-muted">
                <span>Service Charge</span>
                <span id="service-charge">₹569</span>
            </div>
            <hr>
            <div class="summary-item d-flex justify-content-between text-dark fw-bold fs-4">
                <span>You Pay</span>
                <span id="total-price">₹0</span>
            </div>
            <div class="summary-item d-flex justify-content-between text-success fw-semibold">
                <span>Total Saving</span>
                <span id="total-saving">₹0</span>
            </div>
        </div>
 <br>
    </div>

    {{-- room booking --}}
    <div class="col-lg-4 col-md-6 col-sm-12 p-3" style="border:1px solid #ebebeb; background: #fff; border-radius: 10px; margin-left:20px">

        <div class="booking-form">
            <h3>Booking Your Hotel</h3>
            <form action="{{ route('book.room') }}" method="POST" id="bookingForm">
                @csrf
                <div class="check-date">
                    <label for="checkin_date">Check In:</label>
                    <input type="datetime-local" id="checkin_date" name="checkin_date" >
                </div>
                <div class="check-date">
                    <label for="checkout_date">Check Out:</label>
                    <input type="datetime-local" id="checkout_date" name="checkout_date" >
                </div>
                <div class="check-date">
                    <label for="">Guest</label>
                    <input type="number" id="guests" name="guests" min="1" required>
                </div>

                <div class="select-option">
                    <label for="">Rooms</label>
                    <select name="rooms" id="rooms">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                    </select>
                </div>
{{-- 
                <div class="select-option">
                    <label>Room Type :</label>
                        <select id="room_id" name="room_id">
                            @foreach($rooms as $room)
                 
                                <option value="{{ $room->id }}">{{ $room->roomType->name }}</option>
                            @endforeach
                        </select>
                </div> --}}
                
                <div class="select-option">
                    <label>Room Type :</label>
                        <select id="room_id" name="room_id">
                            {{-- @foreach($rooms as $room) --}}
                 
                                <option value="{{ $selectedRoom->id  }}">{{$selectedRoom->roomType->name }}</option>
                            {{-- @endforeach  --}}
                        </select>
                </div>
                <button type="button" id="book-now-btn">Book Now</button>
            </form>
        </div>

    </div>
</div>
<br>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

    // calculate total price 
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    $(document).ready(function() {
    let selectedRoom = @json($selectedRoom); // Get the selected room

    if (selectedRoom) {
        $("#room-image").attr("src", selectedRoom.image ? "{{ asset('storage/') }}/" + selectedRoom.image : "").show();
        $("#selected-room-type").text(selectedRoom.room_type.name); // Display selected room type
        $("#room-price").text(selectedRoom.price);
        $("#room_id").val(selectedRoom.id); // Store selected room ID in hidden input
    }
});


    function updatePrice() {
    let formData = {
        _token: "{{ csrf_token() }}",
        room_id: $("#room_id").val(),
        checkin_date: $("#checkin_date").val(),
        checkout_date: $("#checkout_date").val(),
        guests: $("#guests").val(),
        rooms: $("#rooms").val() // Pass the number of rooms
    };

    $.ajax({
        url: "{{ route('calculate.price') }}",
        type: "POST",
        data: formData,
        success: function(response) {
            if (response.error) {
                alert(response.error);
                return;
            }
            $("#hotel-charges").text(`₹${response.hotel_charges.toFixed(2)}`);
            $("#discount").text(`- ₹${response.discount.toFixed(2)}`);
            $("#sub-total").text(`₹${response.sub_total.toFixed(2)}`);
            $("#taxes").text(`₹${response.taxes.toFixed(2)}`);
            $("#total-price").text(`₹${response.total_price.toFixed(2)}`);
            $("#total-saving").text(`₹${response.discount.toFixed(2)}`);
        },
        error: function(xhr) {
            console.log(xhr.responseJSON);
        }
    });
}

// Bind event listener for room selection
$("#checkin_date, #checkout_date, #guests, #room_id, #rooms").on("change", updatePrice);


    //  Add Booking Functionality
    $(document).ready(function() {
        $("#book-now-btn").on("click", function () {
            let bookingData = {
                _token: "{{ csrf_token() }}",
                room_id: $("#selected_room_id").val(), 
                checkin_date: $("#checkin_date").val(),
                checkout_date: $("#checkout_date").val(),
                guests: $("#guests").val(),
                rooms: $("#rooms").val()
            };

            // Check room availability before booking
            $.ajax({
                url: "{{ route('check.room.availability') }}",
                type: "POST",
                data: bookingData,
                success: function (response) {
                    if (response.available) {
                        // Proceed with booking
                        $.ajax({
                url: "{{ route('book.room') }}",
                type: "POST",
                data: bookingData,
                success: function (response) {
                    console.log(bookingData);
                    Swal.fire({
                        title: "Booking Successful!",
                        text: "Room has been booked successfully.",
                        icon: "success"
                    }).then(() => {
                        // Redirect to the booking details page after user clicks "OK"
                        window.location.href = "{{ route('booking.details', ['id' => 'BOOKING_ID']) }}".replace('BOOKING_ID', response.booking_id);
                    });
                },
                error: function (xhr) {
                    // alert("Booking failed! Please check the console for errors.");
                    Swal.fire({
                        title: "Booking failed!",
                        text: "All fields are required.",
                        icon: "error"});
                }
            });
        }
    },
                error: function (xhr) {
           
                    Swal.fire({
                    title: "Room Book alredy!",
                    text: "Room is already booked for the selected date and Times. ",
                    icon: "success"
                    });// Show error message if room is booked
                }
            });
        });
    });


// $.ajax({
//     url: "{{ route('check.room.availability') }}",
//     type: "POST",
//     data: bookingData,
//     success: function (response) {
//         if (response.available) {
//             // Proceed with booking
//             $.ajax({
//                 url: "{{ route('book.room') }}",
//                 type: "POST",
//                 data: bookingData,
//                 success: function (response) {
//                     console.log(bookingData);
//                     Swal.fire({
//                         title: "Booking Successful!",
//                         text: "Room has been booked successfully.",
//                         icon: "success"
//                     }).then(() => {
//                         // Redirect to the booking details page after user clicks "OK"
//                         window.location.href = "{{ route('booking.details', ['id' => 'BOOKING_ID']) }}".replace('BOOKING_ID', response.booking_id);
//                     });
//                 },
//                 error: function (xhr) {
//                     alert("Booking failed! Please check the console for errors.");
//                 }
//             });
//         }
//     },
//     error: function (xhr) {
//         Swal.fire({
//             title: "Room Already Booked!",
//             text: "The room is already booked for the selected date and time.",
//             icon: "error"
//         });
//     }
// });

</script>

@endsection
