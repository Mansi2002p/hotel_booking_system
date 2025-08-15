<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Hotel;
use App\Models\Review;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class HotelController extends Controller
{
    //dashboard with hotel and all rooms
    public function index()
    {
        $hotels = Hotel::with('media')->get(); // Fetch all hotels
        $hotel = Hotel::with('media')->latest()->first(); // Fetch one featured hotel (latest)

        $rooms = Room::with(['hotel', 'roomType'])->get();

        return view('web.customer.index', compact('hotels', 'hotel', 'rooms'));
    }

    // dhow all hotel
    public function showHotel()
    {
        $hotels = Hotel::with('media')->get();
        // dd($hotel);// Fetch one featured hotel 
        return view('web.customer.hotel', compact('hotels'));
    }

    //  show all rooms
    public function showRooms(Request $request)
    {
        $roomTypes = RoomType::all(); // Fetch all room types

        $query = Room::with(['roomType', 'amenities']); // Load relationships

        if ($request->has('roomtype_id') && !empty($request->roomtype_id)) {
            $query->where('roomtype_id', $request->roomtype_id); // Ensure correct column name
        }

        if ($request->has('availability') && !empty($request->availability)) {
            $query->where('status', $request->availability); // Assuming 'status' column stores availability
        }

        if ($request->has('air_condition') && $request->air_condition !== '') {
            $query->where('air_conditon', $request->air_condition); // Assuming 'air_condition' is a boolean column
        }


        $rooms = $query->paginate(6);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('web.customer.room-list', compact('rooms'))->render() // Use render()
            ]);
        }

        return view('web.customer.rooms', compact('rooms', 'roomTypes')); // Pass data to view
    }

    // show about page
    public function ShowAbout()
    {
        return view('web.customer.about');
    }

    // show contact
    public function ShowContact()
    {
        return view('web.customer.contact');
    }

    // room details
    public function ShowRoomDetails($id)
    {
        $room = Room::with('roomType')->find($id);
        return view('web.customer.roomDetails', compact('room'));
    }


    // hotel detail
    public function showHotelDetails(Request $request, $id)
    {  
        $hotel = Hotel::with(['rooms', 'media', 'amenities'])->findOrFail($id);
        $roomTypes = RoomType::all();
        // $reviews = Review::with(['user','hotels'])->get(); 
        $reviews = Review::with(['user' ,'hotel'])
        ->where('hotel_id', $id)
        ->get(); 

        $roomsQuery = Room::where('hotels_id', $id);

        if ($request->filled('roomtype_id')) {
            $roomsQuery->where('roomtype_id', $request->roomtype_id);
        }

        // if ($request->filled('availability')) {
        //     $roomsQuery->where('status', $request->availability); // Ensure 'status' stores availability
        // }

        if ($request->filled('air_condition')) {
            $roomsQuery->where('air_conditon', $request->air_condition);
        }

        $rooms = $roomsQuery->paginate(6);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('web.customer.hotelrooms', compact('rooms', 'hotel'))->render()
            ]);
        }

        return view('web.customer.hoteldetail', compact('hotel', 'rooms', 'roomTypes', 'reviews'));
    }





    public function getRoomTypes()
    {
        $roomTypes = RoomType::pluck('name')->unique()->values(); // Fetch distinct room types directly
        return response()->json($roomTypes);
    }

    public function getRoomsByType(Request $request)
    {
        $roomTypes = $request->type; // Array of selected room types

        $rooms = Room::whereHas('roomType', function ($query) use ($roomTypes) {
            $query->whereIn('name', $roomTypes); // Fetch rooms that match multiple types
        })
            ->where('status', 'available') // Only available rooms
            ->get(['id', 'room_no']);

        return response()->json($rooms);
    }


    // public function checkAvailability(Request $request)
    // {
    //     $validated = $request->validate([
    //         'check_in' => 'required|date',
    //         'check_out' => 'required|date|after:check_in',
    //         'room_types' => 'required|array',
    //         'room_numbers' => 'required|array',
    //     ]);

    //     $checkIn = $request->check_in;
    //     $checkOut = $request->check_out;
    //     $roomNumbers = $request->room_numbers;

    //     // Fetch booked room IDs
    //     $bookedRooms = DB::table('booking')
    //         ->whereIn('room_id', $roomNumbers)
    //         ->where(function ($query) use ($checkIn, $checkOut) {
    //             $query->whereBetween('check_in_date', [$checkIn, $checkOut])
    //                 ->orWhereBetween('check_in_out', [$checkIn, $checkOut])
    //                 ->orWhere(function ($q) use ($checkIn, $checkOut) {
    //                     $q->where('check_in_date', '<=', $checkIn)
    //                         ->where('check_in_out', '>=', $checkOut);
    //                 });
    //         })
    //         ->pluck('room_id') // Get only booked room IDs
    //         ->toArray();

    //     // Get available rooms by filtering out booked ones
    //     $availableRooms = array_diff($roomNumbers, $bookedRooms);

    //     return response()->json([
    //         'available' => !empty($availableRooms),
    //         'available_rooms' => $availableRooms,
    //         'booked_rooms' => $bookedRooms,
    //         'message' => empty($availableRooms)
    //             ? 'No rooms available for selected dates.'
    //             : 'Rooms available.',
    //     ]);
    // }
    
//  room check avilability
    public function checkAvailability(Request $request){
        $validated = $request->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'roomType' => 'required|array',
            'roomType.*' => 'exists:room_type,name',
            'room_numbers' => 'required|array',
            'room_numbers.*' => 'exists:rooms,id',
        ]);
        
        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);
        $roomNumbers = $request->room_numbers;
        
        // Get Room Type IDs from Room Type Names
        $roomTypeIds = RoomType::whereIn('name', $request->roomType)->pluck('id')->toArray();
        
        // Find booked rooms
        $bookings = Booking::whereIn('room_id', function ($query) use ($roomTypeIds) {
                $query->select('id')->from('rooms')->whereIn('roomtype_id', $roomTypeIds);
            })
            ->where('status', 'confirm')
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in_date', [$checkIn, $checkOut]) // Case: Check-in is inside existing booking
                      ->orWhereBetween('check_in_out', [$checkIn, $checkOut]) // Case: Check-out is inside existing booking
                      ->orWhere(function ($subQuery) use ($checkIn, $checkOut) {
                          $subQuery->where('check_in_date', '<=', $checkIn)
                                   ->where('check_in_out', '>=', $checkOut); // Case: Existing booking fully overlaps
                      });
            })
            ->exists();
        
        if ($bookings) {
            return response()->json([
                'status' => 'error',
                'message' => 'Selected room is already booked for the chosen dates.'
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'Room is available! Proceeding to booking.',
                'redirect' => route('web.rooms')
            ]);
        }
    }

//  hotel city dropdown
    public function getCity(){
        $cities = DB::table('hotels')->select('city')->distinct()->get();
        // $cities = Hotel::select('city')->get();
        // dd($cities);
        return response()->json($cities);
    }




//  city dropown and search by name and city
public function getHotelsByCity(Request $request)
{
    $query = Hotel::query();

    // Filter by city
    if ($request->filled('city')) {
        $query->where('city', $request->input('city'));
    }

    // Search by hotel name or city
    if ($request->filled('query')) {
        $search = $request->input('query');
        $query->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('city', 'LIKE', "%{$search}%");
        });
    }

    $hotels = $query->get();
    
    return view('web.customer.hotellist', compact('hotels'))->render(); 
}

}
