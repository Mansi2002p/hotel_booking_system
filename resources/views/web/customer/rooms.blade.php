@extends('web.layouts.app')

@section('title', 'Room Details')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<!-- Rooms Section Begin -->
<section class="rooms-section spad">
    <div class="container">
        <div class="row">
            <div class="col-4">
                <select id="roomTypeFilter" class="form-control">
                    <option value="">All Room Types</option>
                    @foreach($roomTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-4">
                <select id="airConditionFilter" class="form-control">
                    <option value="">All Types</option>
                    <option value="Ac">Air Conditioned</option>
                    <option value="Non-AC">Non-Air Conditioned</option>
                </select>
            </div>
        </div>
        <br>

        <div class="row" id="roomsContainer">
            @include('web.customer.room-list')
        </div>
    </div>
</section>
<!-- Rooms Section End -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// filtre for room type and ac/non-ac
$(document).ready(function () {
    function loadRooms(filters) {
        $.ajax({
            url: "{{ route('web.rooms') }}",
            type: "GET",
            data: filters,
            dataType: "json",
            success: function (response) {
                if (response.html) {
                    console.log(response)
                    $('#roomsContainer').html(response.html);
                } else {
                    $('#roomsContainer').html('<p>No rooms found.</p>');
                }
            },
            error: function () {
                alert('Error fetching rooms.');
            }
        });
    }

    // Filter by Room Type
    $('#roomTypeFilter').on('change', function () {
        let roomTypeId = $(this).val();
        loadRooms({ roomtype_id: roomTypeId });
    });

    // Filter by Air Conditioning
    $('#airConditionFilter').on('change', function () {
        let roomTypeId = $('#roomTypeFilter').val();
        let airCondition = $(this).val();
        loadRooms({ roomtype_id: roomTypeId, air_condition: airCondition });
    });
});

</script>

@endsection
