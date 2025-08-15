@extends('backend.hotel-owner-layouts.app')

@section('title', 'Hotel List')

@section('content')

<div class="container mt-4">
    <h2>Booking List</h2>
    <table id="bookingTable" class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Room</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>

{{-- <!-- Booking Details Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true" style="background: none">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingModalLabel">Booking Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <span aria-hidden="true">&times;</span>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr><th>ID</th><td id="booking_id"></td></tr>
                        <tr><th>User Name</th><td id="user_name"></td></tr>
                        <tr><th>Room Type</th><td id="room_type"></td></tr>
                        <tr><th>Guests</th><td id="guests"></td></tr>
                        <tr><th>Check-in</th><td id="check_in"></td></tr>
                        <tr><th>Check-out</th><td id="check_out"></td></tr>
                        <tr><th>Total Price</th><td id="total_price"></td></tr>
                        <tr><th>Status</th><td id="status"></td></tr>
                        <tr><th>Payment</th><td id="payment"></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> --}}
<!-- Booking Details Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingModalLabel">Booking Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr><th>ID</th><td id="booking_id"></td></tr>
                        <tr><th>User Name</th><td id="user_name"></td></tr>
                        <tr><th>Room Type</th><td id="room_type"></td></tr>
                        <tr><th>Guests</th><td id="guests"></td></tr>
                        <tr><th>Check-in</th><td id="check_in"></td></tr>
                        <tr><th>Check-out</th><td id="check_out"></td></tr>
                        <tr><th>Total Price</th><td id="total_price"></td></tr>
                        <tr><th>Status</th><td id="status"></td></tr>
                        {{-- <tr><th>Payment</th><td id="payment"></td></tr> --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
    let table = $('#bookingTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('bookings.data') }}",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'user', name: 'user' },
            { data: 'room', name: 'room' },
            { data: 'check_in', name: 'check_in' },
            { data: 'check_out', name: 'check_out' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    // Show booking details in modal
    $(document).on('click', '.viewBooking', function() {
        let bookingId = $(this).data('id');

        $.ajax({
            url: "{{ route('bookings.details') }}",
            type: "GET",
            data: { id: bookingId },
            success: function(response) {
                console.log("Full Response:", response); // Debugging
                if (!response) {
                    alert("No booking data found.");
                    return;
                }

                $('#booking_id').text(response.id ?? 'N/A');
                $('#user_name').text(response.user ? (response.user.first_name + ' ' + response.user.last_name) : 'N/A');
                $('#room_type').text(response.room && response.room.room_type ? response.room.room_type.name : 'N/A');
                $('#guests').text(response.guests ?? 'N/A');
                $('#check_in').text(response.check_in_date ?? 'N/A');
                $('#check_out').text(response.check_in_out ?? 'N/A');
                $('#total_price').text( (response.total_price ?? '0'));
                $('#status').text(response.status ?? 'N/A');
                $('#payment').text(response.payment ?? 'N/A');
                $('#bookingModal').modal('show');
            }

        });
    });
});
</script>

@endsection
