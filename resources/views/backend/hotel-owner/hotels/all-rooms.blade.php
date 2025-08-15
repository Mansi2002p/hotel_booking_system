@extends('backend.hotel-owner-layouts.app')

@section('title', 'All Rooms in ' . $hotel->name)

@section('content')
<div class="container mt-4">
    <h3 class="mt-4 fw-bold">All Rooms in {{ $hotel->name }}</h3>

    {{-- Filters --}}
    <div class="d-flex align-items-center mb-3">
        <label for="room_type" class="me-2 fw-semibold">RoomType:</label>
        <select id="room_type" class="form-select me-3" style="width: 20%;">
            <option value="">All</option>
        </select>
        
        <label for="room_status" class="me-2 fw-semibold" style="margin-left: 110px">Status:</label>
        <select id="room_status" class="form-select" style="width: 20%;">
            <option value="">All</option>
        </select>

        <label for="ac_filter" class="me-2 fw-semibold" style="margin-left: 90px">AirCondtion:</label>
        <select id="ac_filter" class="form-select" style="width: 20%;">
            {{-- <option value="">All</option> --}}
        </select>
    </div>

    <div class="row" id="room-list"></div>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    //  filter roomtype,status and air condtion
    $(document).ready(function() {
        let hotelId = "{{ $hotel->id }}";
    
        function loadRoomTypes() {
            $.ajax({
                url: "{{ route('hotel.roomTypes') }}",
                type: "GET",
                success: function(response) {
                    let dropdown = $('#room_type');
                    dropdown.append(response.map(type => `<option value="${type.id}">${type.name}</option>`));
                }
            });
        }
    // filter room status
        function loadRoomStatuses() {
            $.ajax({
                url: "{{ route('hotel.roomStatuses') }}",
                type: "GET",
                success: function(response) {
                    let dropdown = $('#room_status');
                    dropdown.append(response.map(status => `<option value="${status}">${status.charAt(0).toUpperCase() + status.slice(1)}</option>`));
                }
            });
        }
        // filter ac or non-ac
        function loadAcOptions() {
    $.ajax({
        url: "{{ route('hotel.acOptions') }}", // Fetching data for AC options
        type: "GET",
        success: function(response) {
            let dropdown = $('#ac_filter');
            dropdown.empty(); // Clear existing options
            dropdown.append('<option value="">All</option>'); // Always include "All" option

            // If you want to just add options without dynamic labels, you can append options like this:
            response.forEach(option => {
                dropdown.append(`<option value="${option}">${option}</option>`); // Simple option value
            });
        }
    });
}  
// fetch all rooms
        function fetchRooms() {
            let roomType = $('#room_type').val();
            let roomStatus = $('#room_status').val();
            let acFilter = $('#ac_filter').val();
    
            $.ajax({
                url: "{{ route('hotel.filter') }}",
                type: "GET",
                data: { hotel_id: hotelId, roomtype_id: roomType, status: roomStatus, air_conditon: acFilter },
                success: function(response) {
                    let roomList = $('#room-list');
                    roomList.empty();
    
                    if (response.length > 0) {
                        response.forEach(room => {
                            let images = room.media.length ? room.media.map((image, index) => 
                                `<div class="carousel-item ${index === 0 ? 'active' : ''}">
                                    <img src="${image.original_url}" class="d-block w-100" style="height: 200px; object-fit: cover;">
                                </div>`).join('') : 
                                `<div class="carousel-item active">
                                    <img src="https://via.placeholder.com/200" class="d-block w-100" style="height: 200px; object-fit: cover;">
                                </div>`;
    
                            roomList.append(`
                                <div class="col-md-3 mb-4">
                                    <div class="card shadow">
                                        <div id="carouselRoom${room.id}" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-inner">${images}</div>
                                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselRoom${room.id}" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon"></span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#carouselRoom${room.id}" data-bs-slide="next">
                                                <span class="carousel-control-next-icon"></span>
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">Room No  ${room.room_no}</h5>
                                            <p class="card-text">
                                                <strong> Room Type:</strong> ${room.room_type.name} <br>
                                                <strong>Price:</strong> ${room.price} <br>
                                                <strong>Beds:</strong> ${room.bed_capacity} <br>
                                                   <strong>Air Condtion:</strong> ${room.air_conditon} <br>
                                                <strong>Status:</strong> <span class="badge bg-${room.status === 'available' ? 'success' : 'danger'}">${room.status.charAt(0).toUpperCase() + room.status.slice(1)}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            `);
                        });
                    } else {
                        roomList.append('<p>No rooms found.</p>');
                    }
                }
            });
        }
    
        $('#room_type, #room_status, #ac_filter').on('change', fetchRooms);
        loadRoomTypes();
        loadRoomStatuses();
        loadAcOptions();
        fetchRooms();
    });
</script>
    
