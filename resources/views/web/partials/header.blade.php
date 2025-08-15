
 <!-- Page Preloder -->
 <div id="preloder">
    <div class="loader"></div>
</div>


<!-- Header Section Begin -->
<header class="header-section">
    <div class="top-nav">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <ul class="tn-left">
                        <li><i class="fa fa-phone"></i>{{ __('message.hotel_phone') }} </li>
                        <li><i class="fa fa-envelope"> </i>{{ __('message.hotel_email') }}</li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <div class="tn-right">
                        <div class="top-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-tripadvisor"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                        </div>
                        <a href="#" class="bk-btn" style="text-decoration: none">{{ __('message.booking_now') }}</a>
                        <div class="language-option">
                            <img src="{{asset('img/flag.jpg')}}" alt="">
                            <span>EN <i class="fa fa-angle-down"></i></span>
                            <div class="flag-dropdown">
                                <ul>
                                    <li><a href="#">Zi</a></li>
                                    <li><a href="#">Fr</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="menu-item">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="logo">
                        <a href="./index.html">
                            <img src="{{asset('img/logo.png')}}" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-10">
                    <div class="nav-menu">
                        <nav class="mainmenu">
                            <ul>
                                <li><a href="{{route('web.home')}}" style="text-decoration: none">{{ __('message.home') }}</a></li>
                                <li><a href="{{route('web.hotels')}}"  style="text-decoration: none">{{ __('message.hotels') }}</a></li>
                                <li><a href="{{route('web.rooms')}}"  style="text-decoration: none">{{ __('message.rooms') }}</a></li>
                                <li><a href="{{route('web.about')}}"  style="text-decoration: none">{{ __('message.about') }}</a></li>
                            
                                <li><a href="{{route('web.contact')}}"  style="text-decoration: none">{{ __('message.contact') }}</a></li>
                                @if(auth()->check())
                                <li><a href="./pages.html"> <img src="{{asset('admin/img/profiles/avator1.jpg')}}" alt="" style="width: 38px;border-radius: 50%;"></a>
                                    <ul class="dropdown">
                                        <li><a href="{{route('customer.profile')}}" style="text-decoration: none">{{ __('message.profile') }}</a></li>
                                        <li><a href="{{route('customer.password')}}"  style="text-decoration: none" >{{ __('message.changePassword') }}</a></li>
                                        {{-- <li><a href="{{route('booking.confirmation')}}"  style="text-decoration: none" >{{ __('message.my_booking') }}</a></li> --}}
                                        {{-- <li><a href="{{ route('booking.confirmation', ['id' => Auth::id()]) }}" style="text-decoration: none">
                                            {{ __('message.my_booking') }}
                                        </a></li> --}}
                                        <li><a href="{{ route('booking.confirmation') }}" style="text-decoration: none">
                                            {{ __('message.my_booking') }}
                                        </a></li>
                                        
                                        
                                        <li class="">
                                            <a href="{{ route('logout') }}"  style="text-decoration: none">
                                                ({{ auth()->user()->first_name }}) {{ __('message.logout') }}
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                @else
                                <li class="active">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal"  style="text-decoration: none">{{ __('message.login') }}</a>
                                </li>
                                @endif
                            </ul>
                        </nav>
                        <div class="nav-right search-switch">
                            <i class="icon_search"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Header End -->