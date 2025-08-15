@if($hotels->count() > 0)  {{-- Ensure hotels exist --}}
<div class="row">
    @foreach($hotels as $hotel) {{-- Loop through hotels --}}
        <div class="col-lg-4">
            <div class="blog-item set-bg" 
                data-setbg="{{ $hotel->getFirstMediaUrl('images') ?: asset('img/default-hotel.jpg') }}" 
                style="position: relative;">

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

                        <br>
                        {{-- Star Rating after Date --}}
                        @php
                            $rating = floor($hotel->reviews->avg('rating')) ?? 0; // Only full stars
                        @endphp
                        <span class="hotel-rating" style="color: gold; font-weight: bold; font-size: 22px; margin-top: 5px; display: block;">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $rating)
                                    ⭐ {{-- Full Star --}}
                                @else
                                    ☆ {{-- Empty Star --}}
                                @endif
                            @endfor
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@else
<p class="text-center">No hotels available.</p>
@endif
