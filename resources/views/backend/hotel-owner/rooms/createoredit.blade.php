@extends('backend.hotel-owner-layouts.app')

@section('title', $room ? 'Edit Room' : 'Create Room')

@section('content')
<div class="container mt-5">
    @if(session('success'))
        <div class="alert alert-success" role="alert" data-toggle="tooltip" title="{{ session('success') }}">
            <i class="fa fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif


    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <h2 class="mt-5">{{ $room ? 'Edit Room' : 'Create Room' }}</h2>

    <form action="{{ route('room.createOrUpdate', $room ? $room->id : '') }}" method="POST"  enctype="multipart/form-data">
        @csrf
        @if($room)
            @method('POST')
        @endif

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="room_no">Room Number</label>
                    <input type="number" name="room_no" id="room_no" class="form-control" value="{{ old('room_no', $room ? $room->room_no : '') }}" required>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="roomtype_id">Room Type</label>
                    <select name="roomtype_id" id="roomtype_id" class="form-select" required>
                        @foreach($roomTypes as $roomType)
                            <option value="{{ $roomType->id }}" {{ old('roomtype_id', $room ? $room->roomtype_id : '') == $roomType->id ? 'selected' : '' }}>
                                {{ $roomType->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="hotels_id">Hotel</label>
                    <select name="hotels_id" id="hotels_id" class="form-select" required>
                        @foreach($hotels as $hotel)
                            <option value="{{ $hotel->id }}" {{ old('hotels_id', $room ? $room->hotels_id : '') == $hotel->id ? 'selected' : '' }}>
                                {{ $hotel->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $room ? $room->price : '') }}" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="air_condition">Air Condition</label>
                    <select name="air_conditon" id="air_conditon" class="form-select" required>
                        <option value="Ac" {{ old('air_conditon', $room ? $room->air_conditon : '') == 'Ac' ? 'selected' : '' }}>AC</option>
                        <option value="Non Ac" {{ old('air_conditon', $room ? $room->air_conditon : '') == 'Non Ac' ? 'selected' : '' }}>Non AC</option>
                    </select>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="bed_capacity">Bed Capacity</label>
                    <input type="number" name="bed_capacity" id="bed_capacity" class="form-control" value="{{ old('bed_capacity', $room ? $room->bed_capacity : '') }}" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" name="decsription" class="form-control" value="{{ old('decsription', $room ? $room->decsription : '') }}" required>
                </div>
            </div>
            
            <div class="col-6">
                <label for="images">Room Image</label>
                <input type="file" name="room_images[]" id="images" class="form-control" multiple>
             
                @if($room && $room->getMedia('room_images')->count())
                    <div class="mt-2">
                        @foreach($room->getMedia('room_images') as $image)
                            <img src="{{ $image->getUrl() }}" alt="Room Image" class="img" width="100">
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="room_amenities">Room Amenities</label>
                    <select name="amenities[]" id="room_amenities" class="js-example-basic-multiple" multiple required>
                        @foreach($amenities as $amenity)
                            <option value="{{ $amenity->id }}" 
                                {{ in_array($amenity->id, old('amenities', $room ? $room->amenities->pluck('id')->toArray() : [])) ? 'selected' : '' }}>
                                {{ $amenity->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
            </div>
        </div>



        <button type="submit" class="btn btn-primary mt-3">{{ $room ? 'Update Room' : 'Create Room' }}</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    var $j = jQuery.noConflict();
    $j(document).ready(function () {
        $j('.js-example-basic-multiple').select2();
    });


    $(document).ready(function() {
        // Enable tooltips
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endsection