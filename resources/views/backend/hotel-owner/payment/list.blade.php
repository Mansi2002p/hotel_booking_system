@extends('backend.hotel-owner-layouts.app')

@section('title', 'Profile Update')

@section('content')

<div class="container">
    <table id="paymentTable" class="table table-bordered">
        <thead>
            <tr>
                <th>#ID</th>
                <th>User</th>
                <th>Room</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Payment Method</th>
                <th>Transaction id</th>
            </tr>
        </thead>
    </table>
</div>

<script>
$(document).ready(function() {
    $('#paymentTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("payments.list") }}', // Define this route in web.php
        columns: [
            { data: 'id', name: 'id' },
            { data: 'user', name: 'user' },
            { data: 'room', name: 'room' },
            { data: 'amount', name: 'amount' },
            { data: 'status', name: 'status' },
            { data: 'payment_method', name: 'payment_method' },
            { data: 'transaction_id', name: 'transaction_id' },
            // { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});
</script>

@endsection