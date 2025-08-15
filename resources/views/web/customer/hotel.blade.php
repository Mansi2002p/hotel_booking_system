@extends('web.layouts.app')

@section('title', 'Room Details')

@section('content')

<!-- Blog Section Begin -->
<section class="blog-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <span>Hotel List</span>
                    <h2>Discover Our Hotels</h2>
                </div>
            </div>
        </div>

        @if($hotels->count() > 0)  {{-- Ensure hotels exist --}}
        <div class="row">
            @foreach($hotels as $hotel) {{-- Loop through hotels --}}
                <div class="col-lg-4">
                    <div class="blog-item set-bg" 
                        data-setbg="{{ $hotel->getFirstMediaUrl('images') ?: asset('img/default-hotel.jpg') }}">
                        <div class="bi-text">
                            <span class="b-tag">
                                <a href="{{ route('hotel.detail', $hotel->id) }}" style="text-decoration: none; color:white">
                                    {{ $hotel->name ?? 'No Name Available' }}
                                </a>
                            </span>
                            <h4>
                                <a href="{{ route('hotel.detail', $hotel->id) }}" style="text-decoration: none; color:white">
                                    {{ $hotel->city ?? 'Unknown City' }}
                                </a>
                            </h4>
                            <div class="b-time">
                                <i class="icon_clock_alt"></i> 
                                {{ $hotel->created_at ? $hotel->created_at->format('d M, Y') : 'N/A' }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center">No hotels available.</p>
    @endif
    
    </div>
</section>
<!-- Blog Section End -->

@endsection