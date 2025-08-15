@extends('web.layouts.app')

@section('title', 'Room Details')

@section('content')



<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-10">
                <div class="breadcrumb-text">
                    <h2>{{ $room->roomType->name ?? 'Room Details' }}</h2>
                    <div class="bt-option">
                        <a href="{{ url('/') }}">Home</a>
                        <a href="{{route('web.hotels')}}">Hotels</a>
                        <a href="{{ route('web.rooms') }}">Rooms</a>
                        <span>Details</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="room-details-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12" style=" border:1px solid #ebebeb;background: #fff; border-radius: 10px;">
                <div class="room-details-item">
                    <img src="{{ $room->image ?: asset('img/default-room.jpg') }}" alt="Room Image" style="width: 100% ;margin-top: 10px;" >
                    <div class="rd-text">
                        <div class="rd-title">
                            <h3>{{ $room->roomType->name ?? 'Unknown Type' }}</h3>
                            <h2>{{ $room->price }}<span>/Per night</span></h2>
                        </div>
                        <table>
                            <tbody>
                                <tr>
                                    {{-- <td class="r-o">Size:</td>
                                    <td>30 ft</td> --}}
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
                                    <td class="r-o">Air conditon:</td>
                                    <td>{{ $room->air_conditon}}</td>
                                </tr>
                                <tr>
                                    <td class="r-o">Services:</td>
                                    <td>{{ $room->amenities->pluck('name')->implode(', ') }} </td>
                                </tr>
                                
                            </tbody>
                        </table>

                        <span >
                        <strong>Description</strong>
                          <br>
                                <span class="mt-3">{{ $room->decsription }}</span>
                        </span>
                        <br>
                        {{-- <p>{{ $room->description ?? 'No description available.' }}</p> --}}
                    @if(auth()->check())
                        <!-- If user is logged in, go to booking page -->
                        <a href="{{ route('customer.booking', ['room_id' => $room->id]) }}" class="btn mt-5" style="background-color: #dfa974; color: #fff;  margin-left:130px">
                            Book Now
                        </a>
                    @else
                        <!-- If user is NOT logged in, redirect to login page with intended URL -->
                        <a href="{{ route('login', ['redirect' => route('rooms.show', $room->id)]) }}" class="btn mt-5" style="background-color: #dfa974; color: #fff;">
                            Book Now
                        </a>
                    @endif
                    
                    
                    </div>
                </div>
            </div>

            
        </div>
    </div>
</section>

@endsection
