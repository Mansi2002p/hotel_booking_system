<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
    <div id="sidebar-menu" class="sidebar-menu">
    <ul>
    <li class="active">
    <a href="{{route('admin.dashboard')}}"> <i class="bi bi-grid-fill"></i><span> {{ __('message.dashboard') }}</span> </a>
    </li>
    <li class="submenu">
    <a href="javascript:void(0);"><i class="bi bi-calendar-event-fill "></i><span> {{ __('message.booking') }}</span> <span class="menu-arrow"></span></a>
    <ul>
    <li><a href="productlist.html">{{ __('message.booking') }}</a></li>
    <li><a href="addproduct.html">{{ __('message.add_booking') }}</a></li>
    
    </ul>
    </li>
    <li class="submenu">
    <a href="javascript:void(0);"> <i class="bi bi-house-door-fill "></i><span> {{ __('message.rooms') }}</span> <span class="menu-arrow"></span></a>
    <ul>
    <li><a href="">{{ __('message.rooms') }}</a></li>
    <li><a href="pos.html">{{ __('message.add_rooms') }}</a></li>
    
    </ul>
    </li>
    <li class="submenu">
        <a href="javascript:void(0);"> <i class="bi bi-house-door-fill "></i><span>{{ __('message.room_type') }}</span> <span class="menu-arrow"></span></a>
        <ul>
        <li><a href="{{route('admin.room-list')}}">{{ __('message.room_type_list') }}</a></li>
        <li><a href="{{route('admin.room.createOrEdit')}}">{{ __('message.add_room_type') }}</a></li>
        
        </ul>
        </li>
    <li class="submenu">
        <a href="javascript:void(0);"><i class="bi bi-people-fill"></i><span>{{ __('message.hotels_owner') }} </span> <span class="menu-arrow"></span></a>
    <ul>
    <li><a href="{{route('admin.hotel-owners')}}">{{ __('message.hotels_owner') }} </a></li>
    </ul>
    </li>
    <li class="submenu">
        <a href="javascript:void(0);"><i class="bi bi-people-fill"></i><span>{{ __('message.customer') }} </span> <span class="menu-arrow"></span></a>
    <ul>
    <li><a href="{{route('admin.customers')}}">{{ __('message.customer') }} </a></li>
    </ul>
    </li>
    <li class="submenu">
    <a href="javascript:void(0);"><i class="bi bi-buildings-fill"></i><span> {{ __('message.hotels') }}</span> <span class="menu-arrow"></span></a>
    <ul>
    <li><a href="{{route('admin.hotel-list')}}"> {{ __('message.hotels') }}</a></li>
    <li><a href="createexpense.html"> {{ __('message.add_hotel') }}</a></li>
    </ul>
    </li>
    {{-- <li class="submenu">
    <a href="javascript:void(0);"><i class="bi bi-stack"></i><span> {{ __('message.features') }}</span> <span class="menu-arrow"></span></a>
    <ul>
    <li><a href="quotationList.html">{{ __('message.features') }}</a></li>
     <li><a href="addquotation.html">{{ __('message.add_feature') }}</a></li>
    </ul>
    </li> --}}
    <li class="submenu">
    <a href="javascript:void(0);"><i class="bi bi-gift-fill"></i><span>{{ __('message.amenities') }}</span> <span class="menu-arrow"></span></a>
    <ul>
    <li><a href="{{route('admin.amenities-list')}}">{{ __('message.amenities_list') }}</a></li>
    <li><a href="{{route('admin.amenities.createOrEdit')}}">{{ __('message.add_amenity') }}</a></li>
    </ul>
    </li>
    <li class="submenu">
        <a href="javascript:void(0);"><i class="bi bi-browser-edge"></i><span>{{ __('message.property_type') }}</span> <span class="menu-arrow"></span></a>
        <ul>
        <li><a href="{{route('admin.property-list')}}">{{ __('message.property_type_list') }}</a></li>
        <li><a href="{{route('admin.property.createOrUpdate')}}">{{ __('message.add_property') }} </a></li>
        </ul>
        </li>
    <li class="submenu">
    <a href="javascript:void(0);"><i class="bi bi-credit-card-2-back-fill"></i><span>{{ __('message.payment') }}</span> <span class="menu-arrow"></span></a>
    <ul>
    <li><a href="salesreturnlist.html">{{ __('message.payment_method') }}</a></li>
    <li><a href="createsalesreturn.html">{{ __('message.invoice_list') }}</a></li>
    <li><a href="purchasereturnlist.html">{{ __('message.invoice_details') }}</a></li>
    </ul>
    </li>
    <li class="submenu">
    <a href="javascript:void(0);"> <i class="bi bi-star-fill"></i><span>{{ __('message.rating') }}</span> <span class="menu-arrow"></span></a>
    <ul>
    <li><a href="customerlist.html">{{ __('message.rating_list') }}</a></li>
    <li><a href="addcustomer.html">{{ __('message.room_rating') }}</a></li>
    <li><a href="addcustomer.html">{{ __('message.hotel_rating') }}</a></li>
    </ul>
    </li> 
    </li>
    </ul>
    </div>
    </div>
    </div>