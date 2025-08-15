@extends('backend.hotel-owner-layouts.app')

@section('title', 'Room List')

@section('content')

<div class="container mt-5">
    <h2 class="mt-5">Rooms</h2>
    @if(session('success'))
        <div class="alert alert-success" role="alert" data-toggle="tooltip" title="{{ session('success') }}">
            <i class="fa fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif


    <!-- Add New Room Button -->
    <a href="{{ route('room.createOrEdit') }}" class="btn" style="background-color:#212b36; color:white;">Add New Room</a>

    <!-- Table for displaying rooms -->
    <table class="table table-bordered" id="roomTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Room No</th>
                <th>Room Type</th>
                <th>Hotel</th>
                <th>Price</th>
                <th>Air Condition</th>
                <th>Bed Capacity</th>
                <th>Amenities</th>
          
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be populated by DataTables -->
        </tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    $('#roomTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('rooms.data') }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'room_no', name: 'room_no' },
            { data: 'room_type.name', name: 'roomType.name' },
            { data: 'hotel.name', name: 'hotel.name' },
            { data: 'price', name: 'price' },
            { data: 'air_conditon', name: 'air_conditon' },
            { data: 'bed_capacity', name: 'bed_capacity' },
            { data: 'amenities', name: 'amenities' }, 
     
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});

$(document).ready(function() {
        // Enable tooltips
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

@endsection
