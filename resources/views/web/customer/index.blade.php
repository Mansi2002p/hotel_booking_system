@extends('web.layouts.app')

@section('title', 'About Us')

@section('content')
    <style>
        .select2-container--default .select2-dropdown {
         z-index: 9999 !important;  /* Make sure it appears above the modal */
    }
    </style>
    <!-- Hero Section Begin -->
    <section class="hero-section">
        {{-- login Model --}}
        <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginModalLabel">{{ __('message.login') }} </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="login-container">
                            <form action="{{ route('authenticate') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="login_email" class="form-label">{{ __('message.email') }}</label>
                                    <input type="email" class="form-control" id="login_email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="login_password" class="form-label">{{ __('message.password') }}</label>
                                    <input type="password" class="form-control" id="login_password" name="password" required>
                                </div>
                                <button type="submit" class="btn w-100"  style="background-color:#dfa974;color:white;font-weight:300 ;">{{ __('message.login') }}</button>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <p class="text-center w-100">
                            {{ __('message.dont_have_an_account? ') }}  <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal" style="color: black">{{ __('message.register') }}</a>
                        </p>
                        <p class="text-center w-100">
                            {{ __('message.admin_pannel') }}<a href="{{ route('login') }}" style="color: black">{{ __('message.login') }}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Register Modal -->
        <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginModalLabel">{{ __('message.register') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <div class="login-container">
                            <form action="{{ route('authregister') }}" method="POST">
                                @csrf
                                <div class="row">
                                        <div class="col-6">
                                         <!-- Name Field -->
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label">{{ __('message.first_name') }}</label>
                                                <input type="text" id="fname" name="first_name" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label">{{ __('message.last_name') }}</label>
                                                <input type="text" id="lname" name="last_name" class="form-control" required>
                                            </div>
                                        
                                        </div>
                                 </div>
                               <div class="row">
                                <div class="col-6">
                                      <!-- Email Field -->
                                      <div class="form-group mb-3">
                                        <label for="email" class="form-label">{{ __('message.email') }}</label>
                                        <input type="email" id="email" name="email" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label for="moblieno" class="form-label">{{ __('message.mobile_number') }}</label>
                                        <input type="text" id="moblieno" name="moblieno" class="form-control" required>
                                    </div>
                                </div>
                               </div>

                                <div class="row">
                                    <div class="col-6">
                                         <!-- Password Field -->
                                        <div class="form-group mb-3">
                                            <label for="password" class="form-label">{{ __('message.password') }}</label>
                                            <input type="password" id="password" name="password" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                          <!-- Confirm Password Field -->
                                        <div class="form-group mb-3">
                                            <label for="cpassword" class="form-label">{{ __('message.confirm_password') }}</label>
                                            <input type="password" id="cpassword" name="password_confirmation" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label for="moblieno" class="form-label">{{ __('message.zipcode') }}</label>
                                                <input type="text" id="zipcode" name="zipcode" class="form-control" required>
                                            </div>     
                                        </div>
                                        <div class="col-6">
                                            {{-- <div class="form-group mb-3">
                                                <label for="country-dropdown" class="form-label">Country</label>
                                                <select id="country-dropdown" class="form-select">
                                                </select>
                                            </div> --}}
                                            <div class="form-group mb-3">
                                                <label for=""  class="form-label" id="country-label">{{ __('message.country') }}</label>
                                             
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                                <div class="form-group mb-3">
                                                    <label for=""  class="form-label" id="state-label">{{ __('message.state') }}</label>
                                                    <option value="">{{ __('message.select_state') }}</option>
                                                </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label for="moblieno"  class="form-label" id="city-label">{{ __('message.city') }}</label>
                                                    <option value="">{{ __('message.select_city') }}</option>
                                            </div>
                                        </div>
                                    </div>
                              
                                <div class="form-group">
                                    <label for="cpassword">{{ __('message.address') }}</label>
                                    <textarea name="address" id="address" cols="20" rows="5" class="form-control" ></textarea>
                                </div>

                                <!-- Role Selection -->
                                <div class="form-group mb-3">
                                    <label for="role" class="form-label">{{ __('message.role') }}</label>
                                    <select name="role" id="role" class="form-select" required >
                                        <option value="hotel_owner">{{ __('message.hotel_owner') }}</option>
                                        <option value="customer">{{ __('message.customer') }}</option>
                                    </select>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn w-100 mt-3" style="background-color:#dfa974;color:white;font-weight:300 ;">{{ __('message.register') }}</button>
                            </form>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer text-center">
                        <p class="w-100 mb-1">
                            {{ __('message.already_have_an_account') }}
                            <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" style="color: black">{{ __('message.login') }}</a>
                        </p>
                        <p class="w-100 mb-0">
                            {{ __('message.admin_pannel') }}
                            <a href="{{ route('login') }}" style="color: black">{{ __('message.login') }}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>


        @if($hotel)  {{-- Ensure a single hotel exists --}}
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="hero-text">
                            <h1>{{ $hotel->name }}</h1>
                            <p>{{ $hotel->description }}</p>
                            <a href="#" class="primary-btn">Discover Now</a>
                        </div>
                    </div>
                    
               {{-- check availablity --}}
                    <div class="col-xl-4 col-lg-5 offset-xl-2 offset-lg-1">
                        <div class="booking-form" >
                            <form id="checkAvailabilityForm" >
                                <div class="check-date">
                                    <label for="date-in">Check In:</label>
                                    <input type="datetime-local" class="input" id="date-in" name="check_in" required>
                                </div>
                                <div class="check-date">
                                    <label for="date-out">Check Out:</label>
                                    <input type="datetime-local" class="input" id="date-out" name="check_out" required>
                                </div>
                                <div class="select-option">
                                    <label for="room-type">Room Type:</label>
                                    <select class="js-example-basic-multiple form-control" name="roomType[]" id="room-type" multiple="multiple" style="width:100%" >
                                    </select>
                                </div>
                                <div class="select-option">
                                    <label for="room-numbers">Room Number:</label>
                                    <select name="room_numbers[]" id="room-numbers" style="width:100%" class="form-control" multiple required>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                    </select>
                                </div>
                                <button type="submit">Check Availability</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        
            {{-- Hero Slider --}}
            <div class="hero-slider owl-carousel">
                @if($hotel->hasMedia('images'))
                    @foreach($hotel->getMedia('images') as $image)
                        <div class="hs-item set-bg" data-setbg="{{ $image->getUrl() }}"></div>
                    @endforeach
                @else
                    <div class="hs-item set-bg" data-setbg="{{ asset('img/default-hotel.jpg') }}"></div>
                @endif
            </div>
        @endif
    
    </section>
    <!-- Hero Section End -->
    
    <!-- All Hotel List-->
    <section class="blog-section spad">
        <div class="container">
       
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>{{ __('message.hotel_list') }}</span>
                        <h2>{{ __('message.discover_our_hotels') }}</h2>
                    </div> 
                </div>
             
            </div>
            {{-- city dropdown and search input  --}}
            <div class="row">
                <div class="col-md-4">
                    <label>City:</label>
                    <select class="js-example-basic-multiple form-control" id="cityDropdown" style="width: 100%">
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Search Hotel:</label>
                    <input type="text" id="searchInput" class="form-control" placeholder="Search hotel by name or city">
                </div>
            </div>
            <br>

            <div id="hotelList">
                @include('web.customer.hotellist')
            </div>
        </div>
    </section>
    <!-- Blog Section End -->
    

    <!-- About Us Section Begin -->
    <section class="aboutus-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="about-text">
                        <div class="section-title">
                            <span>{{ __('message.about_us') }}</span>
                            <h2>{{ __('message.intercontinental ') }}<br />{{ __('message.westlake_hotel') }}</h2>
                        </div>
                        <p class="f-para">{{ __('message.sona') }}</p>
                        <p class="s-para">{{ __('message.so_when') }}</p>
                        <a href="#" class="primary-btn about-btn">{{ __('message.read_more') }}</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-pic">
                        <div class="row">
                            <div class="col-sm-6">
                                <img src="{{asset('img/about/about-1.jpg')}}" alt="">
                            </div>
                            <div class="col-sm-6">
                                <img src="{{asset('img/about/about-2.jpg')}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Us Section End -->

    <!-- Services Section End -->
    <section class="services-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>What We Do</span>
                        <h2>Discover Our Services</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-6">
                    <div class="service-item">
                        <i class="flaticon-036-parking"></i>
                        <h4>Travel Plan</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="service-item">
                        <i class="flaticon-033-dinner"></i>
                        <h4>Catering Service</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="service-item">
                        <i class="flaticon-026-bed"></i>
                        <h4>Babysitting</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="service-item">
                        <i class="flaticon-024-towel"></i>
                        <h4>Laundry</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="service-item">
                        <i class="flaticon-044-clock-1"></i>
                        <h4>Hire Driver</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="service-item">
                        <i class="flaticon-012-cocktail"></i>
                        <h4>Bar & Drink</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Services Section End -->

    <!-- Home Room Section Begin -->
    <section class="hp-room-section">
        <div class="container-fluid">
            <div class="hp-room-items">
                <div class="row">
                    @foreach($rooms->take(4) as $room) <!-- Limit to 4 rooms -->
                        <div class="col-lg-3 col-md-6">
                            <div class="hp-room-item set-bg" data-setbg="{{ $room->image ?: asset('img/default-room.jpg') }}">
                                <div class="hr-text">
                                    <h3>{{ $room->roomType->name ?? 'Unknown Type' }}</h3>
                                    <h2>{{ $room->price }}<span>/Per night</span></h2>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td class="r-o">Size:</td>
                                                <td>30 ft</td>
                                            </tr>
                                            <tr>
                                                <td class="r-o">Capacity:</td>
                                                <td>Max person {{ $room->bed_capacity }}</td>
                                            </tr>
                                            <tr>
                                                <td class="r-o">Bed:</td>
                                                <td>{{ $room->bed_capacity > 1 ? 'Multiple Beds' : 'Single Bed' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="r-o">Air Conditon:</td>
                                                <td>{{ $room->air_conditon  }}</td>
                                            </tr>
                                            <tr>
                                                <td class="r-o">Services:</td>
                                                <td>{{ $room->amenities->pluck('name')->take(2)->implode(', ') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <a href="{{ route('rooms.show', $room->id) }}" class="primary-btn" style="text-decoration: none">More Details</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
    
                @if($rooms->isEmpty())
                    <p class="text-center">No rooms available.</p>
                @endif
            </div>
        </div>
    </section>
    
    <br>
    
    <!-- Home Room Section End -->

    <!-- Testimonial Section Begin -->
    {{-- <section class="testimonial-section spad">
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
                        <div class="ts-item">
                            <p>After a construction project took longer than expected, my husband, my daughter and I
                                needed a place to stay for a few nights. As a Chicago resident, we know a lot about our
                                city, neighborhood and the types of housing options available and absolutely love our
                                vacation at Sona Hotel.</p>
                            <div class="ti-author">
                                <div class="rating">
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star-half_alt"></i>
                                </div>
                                <h5> - Alexander Vasquez</h5>
                            </div>
                            <img src="img/testimonial-logo.png" alt="">
                        </div>
                        <div class="ts-item">
                            <p>After a construction project took longer than expected, my husband, my daughter and I
                                needed a place to stay for a few nights. As a Chicago resident, we know a lot about our
                                city, neighborhood and the types of housing options available and absolutely love our
                                vacation at Sona Hotel.</p>
                            <div class="ti-author">
                                <div class="rating">
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star-half_alt"></i>
                                </div>
                                <h5> - Alexander Vasquez</h5>
                            </div>
                            <img src="{{asset('img/testimonial-logo.png')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- Testimonial Section End -->

    <!-- Search model Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch"><i class="icon_close"></i></div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    <!-- Search model end -->

 
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


  
 <script>
    // for register form country,states and city fetch 
    $(document).ready(function () {
        $('#registerModal').on('shown.bs.modal', function () {
          
            $.ajax({
                url: "fetch-countries",
                type: "GET",
                dataType: "json",
                success: function (data) {
                    if (data.countries && data.countries.length > 0) {
                        // Create select element with Select2 classes
                        var countryOptions = '<select class="country-list form-select" name="country">';
                        countryOptions += '<option value="">Select a country...</option>'; // Add placeholder option
                        data.countries.forEach(function(country) {
                            countryOptions += '<option value="' + country.id + '">' + country.name + '</option>';
                        });
                        countryOptions += '</select>';
                        
                        // Remove any existing select element
                        $('#country-label').find('select').remove();
                        
                        // Append the new select element
                        $('#country-label').append(countryOptions);
                        
                        // Initialize Select2
                        $('.country-list').select2({
                            dropdownParent: $("#registerModal"),
                            placeholder: "Select a country...",
                            allowClear: true,
                            width: '100%' // Makes the select2 element full width
                        });
                    } else {
                        console.error("No countries data received.");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching countries:", xhr.responseText);
                }
            });
  
            // States fetch
            $(document).on('change', '.country-list', function () {
            var countryId = $(this).val();
        
                    if (countryId) {
                        $.ajax({
                            url: "fetch-states",
                            type: "GET",
                            data: { country_id: countryId },
                            dataType: "json",
                            success: function (data) {
                                if (data.states && data.states.length > 0) {
                                    var stateOptions = '<select class="state-list form-select" name="state">';
                                    stateOptions += '<option value="">Select a state...</option>';
                                    data.states.forEach(function(state) {
                                        stateOptions += '<option value="' + state.id + '">' + state.name + '</option>';
                                    });
                                    stateOptions += '</select>';
                                    
                                    $('#state-label').find('select').remove();
                                    $('#state-label').append(stateOptions);
                                    
                                    $('.state-list').select2({
                                        dropdownParent: $("#registerModal"),
                                        placeholder: "Select a state...",
                                        allowClear: true,
                                        width: '100%'
                                    });
                                } else {
                                    console.error("No states data received.");
                                }
                            },
                            error: function (xhr, status, error) {
                                console.error("Error fetching states:", xhr.responseText);
                            }
                        });
                    } else {
                        $('#state-label').find('select').remove();
                        $('#city-label').find('select').remove();
                    }
            });


            //city fetch
            $(document).on('change', '.state-list', function () {
            var stateId = $(this).val();
        
                if (stateId) {
                    $.ajax({
                        url: "fetch-cities",
                        type: "GET",
                        data: { state_id: stateId },
                        dataType: "json",
                        success: function (data) {
                            if (data.cities && data.cities.length > 0) {
                                var cityOptions = '<select class="city-list form-select" name="city">';
                                cityOptions += '<option value="">Select a city...</option>';
                                data.cities.forEach(function(city) {
                                    cityOptions += '<option value="' + city.id + '">' + city.name + '</option>';
                                });
                                cityOptions += '</select>';
                                
                                $('#city-label').find('select').remove();
                                $('#city-label').append(cityOptions);
                                
                                $('.city-list').select2({
                                    dropdownParent: $("#registerModal"),
                                    placeholder: "Select a city...",
                                    allowClear: true,
                                    width: '100%'
                                });
                            } else {
                                console.error("No cities data received.");
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error("Error fetching cities:", xhr.responseText);
                        }
                    });
                } else {
                    $('#city-label').find('select').remove();
                }
            });

         });

    });



// check room availability and get room type 
$(document).ready(function () {
    $('.nice-select').remove();

    // Initialize Select2
    $("#room-type, #room-numbers").select2({
        width: '100%',
        placeholder: "Select Options",
    });

    // Fetch Room Types
    $.ajax({
        url: "/get-room-types",
        type: "GET",
        success: function (response) {
            console.log("Room Types:", response);
            response.forEach(type => {
                $("#room-type").append(`<option value="${type}">${type}</option>`);
            });
            $("#room-type").trigger('change');
        },
        error: function (xhr) {
            console.error("Error fetching room types:", xhr.responseText);
        }
    });

    $('#checkAvailabilityForm').submit(function (e) {
        e.preventDefault(); // Prevent default form submission

        $.ajax({
            url: "{{ route('check-availability') }}", // Laravel route
            method: "POST",
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log("Availability Response:", response);
                if (response.status === 'error') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Room Not Available',
                        text: response.message,
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Room Available!',
                        text: response.message,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Proceed'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = response.redirect;
                        }
                    });
                }
            },
            error: function (xhr) {
                console.error("Error:", xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong. Please try again later.'
                });
            }
        });
    });
});


// city dropdown and search input
$(document).ready(function() {
    // Initialize Select2 for city dropdown
    $('#cityDropdown').select2({
        placeholder: "Select a city",
        allowClear: true
    });

    // Fetch distinct cities
    $.ajax({
        url: '/get-cities', // Laravel route to fetch unique cities
        type: 'GET',
        success: function(response) {
            let cityDropdown = $('#cityDropdown');
            cityDropdown.empty().append('<option value="">All Cities</option>');

            $.each(response, function(index, city) {
                if (city.city) {
                    cityDropdown.append(`<option value="${city.city}">${city.city}</option>`);
                }
            });
        },
        error: function(xhr) {
            console.log("AJAX Error:", xhr.responseText);
        }
    });

    // Function to fetch hotels dynamically
    function fetchHotels() {
        let selectedCity = $('#cityDropdown').val(); // Get selected city
        let searchQuery = $('#searchInput').val().trim(); // Get search query

        $.ajax({
            url: '/get-hotels',  // Laravel route to fetch hotels
            type: 'GET',
            data: { city: selectedCity, query: searchQuery }, // Send city & search query
            success: function(response) {
                $('#hotelList').html(response); // Load hotels dynamically

                // Reapply background images
                $('.set-bg').each(function() {
                    let bg = $(this).data('setbg');
                    $(this).css('background-image', `url(${bg})`);
                });
            },
            error: function(xhr) {
                console.log("AJAX Error:", xhr.responseText);
            }
        });
    }

    // Trigger search when city is selected
    $('#cityDropdown').on('change', fetchHotels);

    // Trigger search when typing in input field (real-time search)
    $('#searchInput').on('keyup', fetchHotels);
});



    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("role").style.display = "block"; // or "inline-block"
    });






</script>
 

    @endsection
