<!-- Rooms List -->

    @forelse($rooms as $room)
        <div class="col-lg-4 col-md-6">
            <div class="room-item">
                <img src="{{ $room->image ?: asset('img/default-room.jpg') }}" alt="">
                <div class="ri-text">
                    <h4>{{ $room->roomType->name ?? 'Unknown Type' }}</h4>
                    <h3>{{ $room->price }}<span> /Per night</span></h3>
                    <table>
                        <tbody>
                         
                            <tr>
                                <td class="r-o">Capacity:</td>
                                <td>Max person {{ $room->bed_capacity }}</td>
                            </tr>
                          
                            <tr>
                                <td class="r-o">Air Condition:</td>
                                <td>{{ $room->air_conditon}}</td>
                            </tr>
                   
                            <tr>
                                <td class="r-o">Amenities:</td>
                                <td>
                                    {{ $room->amenities->pluck('name')->take(2)->implode(', ') }} 
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <a href="{{ route('rooms.show', $room->id) }}" class="primary-btn" style="text-decoration: none">More Details</a>
                    <br>
                    @if(auth()->check())
                        <a href="{{ route('customer.booking', ['room_id' => $room->id]) }}" class="btn mt-3" style="background-color: #dfa974; color: #fff;  margin-left:130px">
                            Book Now
                        </a>
                    @else
                        <a href="{{ route('login', ['redirect' => route('rooms.show', $room->id)]) }}" class="btn mt-3" style="background-color: #dfa974; color: #fff;  margin-left:130px">
                            Book Now
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-lg-12">
            <p class="text-center">No rooms available.</p>
        </div>
    @endforelse
</div>

<!-- Updated Pagination -->
<div class="col-lg-12 d-flex justify-content-center">
    <div class="room-pagination">
        {!! $rooms->links('pagination::bootstrap-4') !!}
    </div>
</div>
