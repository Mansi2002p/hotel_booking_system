@extends('web.layouts.app')

@section('title',  ' - Hotel Details')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<div class="container py-5">
    <div class="row">
        {{-- Hotel Image --}}
        <div class="col-md-6">
            <img src="{{ $hotel->getImageAttribute() }}" alt="{{ $hotel->name }}" class="img-fluid rounded shadow">
        </div>

        {{-- Hotel Details --}}
        <div class="col-md-6">
            <h2 style="color: #dfa974;">{{ $hotel->name }}</h2>
            <p><i class="bi bi-map"></i>  <strong>Address:</strong>{{ $hotel->address }}</p>
            <p><i class="bi bi-info-circle-fill text-primary"></i> <strong>Description:</strong> {{ $hotel->description }}</p>
            <p><i class="bi bi-star-fill text-warning"></i> <strong>Star  Category:</strong> {{ $hotel->star_category }} Stars</p>
            <p><i class="bi bi-telephone-fill text-success"></i> <strong>Phone:</strong> {{ $hotel->Phoneno }}</p>
            <p><i class="bi bi-envelope-fill text-danger"></i> <strong>Email:</strong> {{ $hotel->email }}</p>
            <p><i class="bi bi-globe text-info"></i> <strong>Website:</strong> <a href="{{ $hotel->website }} " target="_blank" style="text-decoration: none ; color :black">{{ $hotel->website }}</a></p>
            <p><i class="bi bi-database-fill-check text-dark"></i>  <strong>Services:</strong> 
                {{ $hotel->amenities->pluck('name')->implode(', ') }}
            </p>
            {{-- @dd($hotel->map) --}}
            {{-- <p><i class="bi bi-geo-alt-fill"  id="map" style="height: 400px; width: 100%;"></i> <strong>Location: </strong>{{$hotel->map}}</p> --}}
        </div>
    </div>
</div>
    {{-- Available Rooms Section --}}
    <h2 class="mt-5 text-center">Available Rooms</h2>
        <div class="container">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Room Type:</label>
                    <select id="roomTypeFilter" class="form-control">
                        <option value="">All</option>
                        @foreach($roomTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- <div class="col-md-4">
                    <label>Availability:</label>
                    <select id="availabilityFilter" class="form-control">
                        <option value="">All</option>
                        <option value="available">Available</option>
                        <option value="booked">Booked</option>
                    </select>
                </div> --}}
                <div class="col-md-4">
                    <label>Air Conditioning:</label>
                    <select id="airConditionFilter" class="form-control">
                        <option value="">All Types</option>
                        <option value="Ac">Air Conditioned</option>
                        <option value="Non-AC">Non-Air Conditioned</option>
                    </select>
                </div>
            </div>
         
      <br>
                <div class="row" id="roomsContainer">
                    @include('web.customer.hotelrooms')
                </div>

             </div>
        

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAtP9tAn-UVCKVzbH5s8ShZG1JNv1N0Lz0&callback=initMap"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Map Container -->
<div id="map" style="height: 400px; width: 100%;"></div>

   <!-- Testimonial Section Begin -->
   <section class="testimonial-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <span>Testimonials</span>
                    <h2>What Customers Say?</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="testimonial-slider owl-carousel">
                    @foreach($reviews as $review)
                        <div class="ts-item">
                            <p>{{ $review->review }}</p>
                            <div class="ti-author">
                                <div class="rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="{{ $i <= $review->rating ? 'icon_star' : 'icon_star_alt' }}"></i>
                                    @endfor
                                </div>
                                <h5> - {{ $review->user->first_name }}</h5>
                            </div>
                            <img src="{{ asset('img/testimonial-logo.png') }}" alt="">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonial Section End -->


<script>
    function initMap() {
            // Extract latitude & longitude directly from Laravel Blade
            var hotelLocation = { 
                lat: parseFloat("{{ explode(',', $hotel->map)[0] ?? 0 }}"), 
                lng: parseFloat("{{ explode(',', $hotel->map)[1] ?? 0 }}") 
            };
            // console.log(hotelLocation);
            

            // Check if coordinates are valid
            if (isNaN(hotelLocation.lat) || isNaN(hotelLocation.lng)) {
                console.error("Invalid latitude or longitude.");
                return;
            }

            // Initialize Google Map
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: hotelLocation
            });

            // Add Marker
            new google.maps.Marker({
                position: hotelLocation,
                map: map,
                title: "{{ $hotel->name }}"
            });
    }




//  filter for room type and ac/non-ac
$(document).ready(function () {
    let filters = {}; // Store all filters

    function loadRooms() {
        $.ajax({
            url: "{{ route('hotel.detail', $hotel->id) }}",
            type: "GET",
            data: filters,
            dataType: "json",
            success: function (response) {
                if (response.html) {
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

    // Step 1: Filter by Room Type
    $('#roomTypeFilter').on('change', function () {
        filters.roomtype_id = $(this).val() || null;
        loadRooms();
    });

    // Step 2: Filter by Availability
    // $('#availabilityFilter').on('change', function () {
    //     filters.availability = $(this).val() || null;
    //     loadRooms();
    // });

    // Step 3: Filter by Air Conditioning
    $('#airConditionFilter').on('change', function () {
        filters.air_condition = $(this).val() || null;
        loadRooms();
    });
});


</script>





@endsection 
