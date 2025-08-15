<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
    <div id="sidebar-menu" class="sidebar-menu">
    <ul>
    <li class="active">
    <a href="{{route('owner.dashboard')}}"> <i class="bi bi-grid-fill"></i><span> {{ __('message.dashboard') }}</span> </a>
    </li>
    <li class="submenu">
    <a href="javascript:void(0);"><i class="bi bi-calendar-event-fill "></i><span> {{ __('message.booking') }}</span> <span class="menu-arrow"></span></a>
    <ul>
    <li><a href="{{route('bookings.index')}}">{{ __('message.booking') }}</a></li>
    <li><a href="addproduct.html">{{ __('message.add_booking') }}</a></li>
    
    </ul>
    </li>
    <li class="submenu">
    <a href="javascript:void(0);"> <i class="bi bi-house-door-fill "></i><span> {{ __('message.rooms') }}</</span> <span class="menu-arrow"></span></a>
    <ul>
    <li><a href="{{ route('rooms.index')}}">{{ __('message.rooms') }}</a></li>
    <li><a href="{{ route('room.createOrEdit')}}">{{ __('message.add_rooms') }}</a></li>
    </ul>
    </li>
    <li class="submenu">
        <a href="javascript:void(0);"><i class="bi bi-people-fill"></i><span> {{ __('message.customer') }}</span> <span class="menu-arrow"></span></a>
    <ul>
    <li><a href="purchaselist.html">{{ __('message.customer') }} </a></li>
  
    </ul>
    </li>
    <li class="submenu">
    <a href="javascript:void(0);"><i class="bi bi-buildings-fill"></i><span> {{ __('message.hotels') }}</span> <span class="menu-arrow"></span></a>
    <ul>
    <li><a href="{{route('owner.index')}}">{{ __('message.hotels') }}</a></li>
    <li><a href="{{route('owner.createOrEdit')}}"> {{ __('message.add_hotel') }}</a></li>
    </ul>
    </li>
    
    {{-- <li class="submenu">
    <a href="javascript:void(0);"><i class="bi bi-gift-fill"></i><span>Amenities</span> <span class="menu-arrow"></span></a>
    <ul>
    <li><a href="transferlist.html">Amenities List</a></li>
    <li><a href="addtransfer.html">Add New Amenities </a></li>
    </ul>
    </li> --}}
    <li class="submenu">
    <a href=""><i class="bi bi-credit-card-2-back-fill"></i><span>{{ __('message.payment') }}</span> <span class="menu-arrow"></span></a>
    <ul>
    <li><a href="{{route('payment.showPayment')}}">{{ __('message.payment_method') }}</a></li>
    <li><a href="createsalesreturn.html">{{ __('message.invoice_list') }} </a></li>
    <li><a href="purchasereturnlist.html">{{ __('message.invoice_details') }}</a></li>
    </ul>
    </li>
    <li class="submenu">
    <a href="javascript:void(0);"> <i class="bi bi-star-fill"></i><span>{{ __('message.rating') }}</span> <span class="menu-arrow"></span></a>
    <ul>
    <li><a href="{{route('rate.showRate')}}">{{ __('message.rating_list') }}</a></li>
    <li><a href="addcustomer.html">{{ __('message.room_rating') }}</a></li>
    <li><a href="addcustomer.html">{{ __('message.hotel_rating') }}</a></li>
    </ul>
    </li> 
    </li>
    </ul>
    </div>
    </div>
    </div>