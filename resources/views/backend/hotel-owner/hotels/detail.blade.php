@extends('backend.hotel-owner-layouts.app')

@section('title', $hotel->name . ' - Details')

@section('content')
<div class="container mt-5">
    <h2>{{ $hotel->name }} - Details</h2>
    {{-- @dd($hotel) --}}
    <div class="card mt-3 p-3">
        <h4 class="fw-bold">Hotel Information</h4>
        <br>
        <div class="row">
            <div class="col-6">
                <p><strong>Hotel Name:</strong>  {{ $hotel->name }}</p>
            </div>
            <div class="col-6">
                <p><strong>Property Type:</strong> {{ $hotel->property_type_id}}</p> 
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-6">
                <p><strong>City:</strong> {{ $hotel->city}}</p>
            </div>
            <div class="col-6">
                <p><strong>Address:</strong> {{ $hotel->address }}</p>
            
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-6">
                <p><strong>Pincode:</strong> {{ $hotel->pincode}}</p>
            </div>
            <div class="col-6">
                <p><strong>Email:</strong> {{ $hotel->email }}</p>
            </div>
          
        </div>
        <br>
        <div class="row">
            <div class="col-6">
                <p><strong>Phone:</strong> {{ $hotel->Phoneno }}</p>
            </div>
            <div class="col-6">
                <p><strong>Telephoneno:</strong> {{ $hotel->telephoneno }}</p>
            </div>
        </div>
        <br>
        <div class="row">
                <div class="col-6">
                    <p><strong>Amenities:</strong> 
                        @if ($hotel->amenities->isNotEmpty())
                            @foreach ($hotel->amenities as $amenity)
                                {{ $amenity->name }}@if(!$loop->last), @endif
                            @endforeach
                        @else
                            No amenities available.
                        @endif
                    </p>
                </div>
                <div class="col-6">
                    <p><strong>Star Category:</strong> {{ $hotel->star_category}}</p>   
                </div>
        </div>
        <br>
        <div class="row">
            <div class="col-6">
                <p><strong>Website:</strong> {{ $hotel->website}}</p>   
            </div>
            <div class="col-6">
                <p><strong>Status:</strong> {{ ucfirst($hotel->status) }}</p>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-6">
                <p><strong>Nearest Railwaystation:</strong> {{ $hotel->nearest_railwaystation }}</p>
            </div>
            <div class="col-6">
                <p><strong>Nearest Airport:</strong> {{ $hotel->nearest_airport }}</p>
            </div>
        </div>
        <br> 
        <div class="row">
            <div class="col-12">
                <p><strong>Hotel Description:</strong> {{ $hotel->description }}</p>
            </div>
        </div>
   

        <h3 class="mt-4 fw-bold">Rooms in {{ $hotel->name }}</h3>
        <div class="row">
            @foreach ($roomsLimited as $room)
                <div class="col-md-3 mb-4">
                    <div class="card shadow">
                        
                        {{-- Image Slider --}}
                        <div id="carouselRoom{{ $room->id }}" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @if($room->getMedia('room_images')->count())
                                    @foreach($room->getMedia('room_images') as $key => $image)
                                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                            <img src="{{ $image->getUrl() }}" class="d-block w-100" style="height: 200px; object-fit: cover;">
                                        </div>
                                    @endforeach
                                @else
                                    <div class="carousel-item active">
                                        <img src="https://via.placeholder.com/200" class="d-block w-100" style="height: 200px; object-fit: cover;">
                                    </div>
                                @endif
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselRoom{{ $room->id }}" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselRoom{{ $room->id }}" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </button>
                        </div>
        
                        {{-- Room Details --}}
                        <div class="card-body">
                            <h5 class="card-title">Room {{ $room->room_no }}</h5>
                            <p class="card-text">
                                <strong>Type:</strong> {{ $room->roomType->name }} <br>
                                <strong>Price:</strong> ${{ $room->price }} <br>
                                <strong>Beds:</strong> {{ $room->bed_capacity }} <br>
                                <strong>AC:</strong> {{ $room->air_conditon }} <br>
                                <strong>Status:</strong> <span class="badge bg-{{ $room->status == 'available' ? 'success' : 'danger' }}">{{ ucfirst($room->status) }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach

                {{-- View All Button --}}
                @if($hotel->rooms->count() > 4)
                <div class="text-center mt-4">
                    <a href="{{ route('hotel.allRooms', $hotel->id) }}" class="btn btn-dark">View All Rooms</a>
                </div>
            @endif
            
        </div>
        
    
        
</div>
</div>
@endsection
