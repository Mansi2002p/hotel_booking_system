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
                        <h5 class="modal-title" id="loginModalLabel">Login</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="login-container">
                            <form action="{{ route('authenticate') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="login_email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="login_email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="login_password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="login_password" name="password" required>
                                </div>
                                <button type="submit" class="btn w-100"  style="background-color:#dfa974;color:white;font-weight:300 ;">Login</button>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <p class="text-center w-100">
                            Don't have an account?   <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal" style="color: black">Register</a>
                        </p>
                        <p class="text-center w-100">
                           Admin Pannel <a href="{{ route('login') }}" style="color: black">Login</a>
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
                        <h5 class="modal-title" id="loginModalLabel">Register</h5>
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
                                                <label for="name" class="form-label">First Name</label>
                                                <input type="text" id="fname" name="fname" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label">Last Name</label>
                                                <input type="text" id="lname" name="lname" class="form-control" required>
                                            </div>
                                        
                                        </div>
                                 </div>
                               <div class="row">
                                <div class="col-6">
                                      <!-- Email Field -->
                                      <div class="form-group mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" id="email" name="email" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label for="moblieno" class="form-label">Mobile Number</label>
                                        <input type="text" id="moblieno" name="moblieno" class="form-control" required>
                                    </div>
                                </div>
                               </div>

                                <div class="row">
                                    <div class="col-6">
                                         <!-- Password Field -->
                                        <div class="form-group mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" id="password" name="password" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                          <!-- Confirm Password Field -->
                                        <div class="form-group mb-3">
                                            <label for="cpassword" class="form-label">Confirm Password</label>
                                            <input type="password" id="cpassword" name="password_confirmation" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label for="moblieno" class="form-label">zipcode</label>
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
                                                <label for="" class="form-label" id="country-label">Country</label>
                                             
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                                <div class="form-group mb-3">
                                                    <label for="" class="form-label" id="state-label">State</label>
                                                    <option value="">Select a state...</option>
                                                </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label for="moblieno"class="form-label" id="city-label">City</label>
                                                    <option value="">Select a city...</option>
                                            </div>
                                        </div>
                                    </div>
                              
                                <div class="form-group">
                                    <label for="cpassword">Address</label>
                                    <textarea name="address" id="address" cols="20" rows="5" class="form-control" ></textarea>
                                </div>

                                <!-- Role Selection -->
                                <div class="form-group mb-3">
                                    <label for="role" class="form-label">Role</label>
                                    <select name="role" id="role" class="form-select" required>
                                        <option value="hotel_owner">Hotel Owner</option>
                                        <option value="customer">Customer</option>
                                    </select>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn w-100 mt-3" style="background-color:#dfa974;color:white;font-weight:300 ;">Register</button>
                            </form>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer text-center">
                        <p class="w-100 mb-1">
                            Already have an account? 
                            <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" style="color: black">Login</a>
                        </p>
                        <p class="w-100 mb-0">
                            Admin Panel
                            <a href="{{ route('login') }}" style="color: black">Login</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>


        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="hero-text">
                        <h1>Sona A Luxury Hotel</h1>
                        <p>Here are the best hotel booking sites, including recommendations for international
                            travel and for finding low-priced hotel rooms.</p>
                        <a href="#" class="primary-btn">Discover Now</a>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5 offset-xl-2 offset-lg-1">
                    <div class="booking-form">
                        <h3>Booking Your Hotel</h3>
                        <form action="#">
                            <div class="check-date">
                                <label for="date-in">Check In:</label>
                                <input type="text" class="date-input" id="date-in">
                                <i class="icon_calendar"></i>
                            </div>
                            <div class="check-date">
                                <label for="date-out">Check Out:</label>
                                <input type="text" class="date-input" id="date-out">
                                <i class="icon_calendar"></i>
                            </div>
                            <div class="select-option">
                                <label for="guest">Guests:</label>
                                <select id="guest">
                                    <option value="">2 Adults</option>
                                    <option value="">3 Adults</option>
                                </select>
                            </div>
                            <div class="select-option">
                                <label for="room">Room:</label>
                                <select id="room">
                                    <option value="">1 Room</option>
                                    <option value="">2 Room</option>
                                </select>
                            </div>
                            <button type="submit">Check Availability</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-slider owl-carousel">
            <div class="hs-item set-bg" data-setbg="{{asset('img/hero/hero-1.jpg')}}"></div>
            <div class="hs-item set-bg" data-setbg="{{asset('img/hero/hero-2.jpg')}}"></div>
            <div class="hs-item set-bg" data-setbg="{{asset('img/hero/hero-3.jpg')}}"></div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- About Us Section Begin -->
    <section class="aboutus-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="about-text">
                        <div class="section-title">
                            <span>About Us</span>
                            <h2>Intercontinental LA <br />Westlake Hotel</h2>
                        </div>
                        <p class="f-para">Sona.com is a leading online accommodation site. We're passionate about
                            travel. Every day, we inspire and reach millions of travelers across 90 local websites in 41
                            languages.</p>
                        <p class="s-para">So when it comes to booking the perfect hotel, vacation rental, resort,
                            apartment, guest house, or tree house, we've got you covered.</p>
                        <a href="#" class="primary-btn about-btn">Read More</a>
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
                    <div class="col-lg-3 col-md-6">
                        <div class="hp-room-item set-bg" data-setbg="{{asset('img/room/room-b1.jpg')}}">
                            <div class="hr-text">
                                <h3>Double Room</h3>
                                <h2>199$<span>/Pernight</span></h2>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="r-o">Size:</td>
                                            <td>30 ft</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Capacity:</td>
                                            <td>Max persion 5</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Bed:</td>
                                            <td>King Beds</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Services:</td>
                                            <td>Wifi, Television, Bathroom,...</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="#" class="primary-btn">More Details</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="hp-room-item set-bg" data-setbg="{{asset('img/room/room-b2.jpg')}}">
                            <div class="hr-text">
                                <h3>Premium King Room</h3>
                                <h2>159$<span>/Pernight</span></h2>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="r-o">Size:</td>
                                            <td>30 ft</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Capacity:</td>
                                            <td>Max persion 5</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Bed:</td>
                                            <td>King Beds</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Services:</td>
                                            <td>Wifi, Television, Bathroom,...</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="#" class="primary-btn">More Details</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="hp-room-item set-bg" data-setbg="{{asset('img/room/room-b3.jpg')}}">
                            <div class="hr-text">
                                <h3>Deluxe Room</h3>
                                <h2>198$<span>/Pernight</span></h2>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="r-o">Size:</td>
                                            <td>30 ft</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Capacity:</td>
                                            <td>Max persion 5</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Bed:</td>
                                            <td>King Beds</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Services:</td>
                                            <td>Wifi, Television, Bathroom,...</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="#" class="primary-btn">More Details</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="hp-room-item set-bg" data-setbg="{{asset('img/room/room-b4.jpg')}}">
                            <div class="hr-text">
                                <h3>Family Room</h3>
                                <h2>299$<span>/Pernight</span></h2>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="r-o">Size:</td>
                                            <td>30 ft</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Capacity:</td>
                                            <td>Max persion 5</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Bed:</td>
                                            <td>King Beds</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Services:</td>
                                            <td>Wifi, Television, Bathroom,...</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="#" class="primary-btn">More Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Home Room Section End -->

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
    </section>
    <!-- Testimonial Section End -->

    <!-- Blog Section Begin -->
    <section class="blog-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Hotel List</span>
                        <h2>Our Blog & Event</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="blog-item set-bg" data-setbg="{{asset('img/blog/blog-1.jpg')}}">
                        <div class="bi-text">
                            <span class="b-tag">Travel Trip</span>
                            <h4><a href="#">Tremblant In Canada</a></h4>
                            <div class="b-time"><i class="icon_clock_alt"></i> 15th April, 2019</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog-item set-bg" data-setbg="{{asset('img/blog/blog-2.jpg')}}">
                        <div class="bi-text">
                            <span class="b-tag">Camping</span>
                            <h4><a href="#">Choosing A Static Caravan</a></h4>
                            <div class="b-time"><i class="icon_clock_alt"></i> 15th April, 2019</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog-item set-bg" data-setbg="{{asset('img/blog/blog-3.jpg')}}">
                        <div class="bi-text">
                            <span class="b-tag">Event</span>
                            <h4><a href="#">Copper Canyon</a></h4>
                            <div class="b-time"><i class="icon_clock_alt"></i> 21th April, 2019</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="blog-item small-size set-bg" data-setbg="{{asset('img/blog/blog-wide.jpg')}}">
                        <div class="bi-text">
                            <span class="b-tag">Event</span>
                            <h4><a href="#">Trip To Iqaluit In Nunavut A Canadian Arctic City</a></h4>
                            <div class="b-time"><i class="icon_clock_alt"></i> 08th April, 2019</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog-item small-size set-bg" data-setbg="{{asset('img/blog/blog-10.jpg')}}">
                        <div class="bi-text">
                            <span class="b-tag">Travel</span>
                            <h4><a href="#">Traveling To Barcelona</a></h4>
                            <div class="b-time"><i class="icon_clock_alt"></i> 12th April, 2019</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->

  
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


 <script>
    $(document).ready(function () {
        $('#registerModal').on('shown.bs.modal', function () {
          
            $.ajax({
                url: "fetch-countries",
                type: "GET",
                dataType: "json",
                success: function (data) {
                    if (data.countries && data.countries.length > 0) {
                        // Create select element with Select2 classes
                        var countryOptions = '<select class="country-list form-select" name="countries">';
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
                                    var stateOptions = '<select class="state-list form-select" name="states">';
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
                                var cityOptions = '<select class="city-list form-select" name="cities">';
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
</script>
 

    @endsection
