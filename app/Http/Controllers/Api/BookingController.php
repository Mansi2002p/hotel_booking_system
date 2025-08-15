<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use App\Models\RoomType;

use App\Helpers\PriceHelper;
use Illuminate\Support\Carbon;

class BookingController extends Controller
{


    public function getRoomTypes()
    {
        $roomTypes = RoomType::all();
        return response()->json($roomTypes);
    }




    public function checkRooms(Request $request)
    {
        // dd($request->all());

        $roomTypeId = $request->input('roomtype_id');
        $checkin = Carbon::parse($request->input('check_in_date'));
        $checkout = Carbon::parse($request->input('check_in_out'));

        // Fetch rooms of the given type
        $isBooked = Booking::whereHas('room', function ($query) use ($roomTypeId) {
            $query->where('roomtype_id', $roomTypeId);
        })
            ->where(function ($query) use ($checkin, $checkout) {
                $query->whereBetween('check_in_date', [$checkin, $checkout])
                    ->orWhereBetween('check_in_out', [$checkin, $checkout])
                    ->orWhere(function ($query) use ($checkin, $checkout) {
                        $query->where('check_in_date', '<=', $checkin)
                            ->where('check_in_out', '>=', $checkout);
                    });
            })
            ->exists();

        // dd($isBooked);

        if ($isBooked) {
            return response()->json([
                'available' => false,
                'message' => 'Rooms of this type are already booked for the selected dates.'
            ], 200);
        }

        return response()->json([
            'available' => true,
            'message' => 'Rooms of this type are available for booking.'
        ], 200);
    }



    public function index()
    {
        return response()->json(Booking::with('room', 'user')->get());
    }




    public function store(Request $request)
    {

        $prices = PriceHelper::calculateTotalPrice(
            $request->room_id,
            $request->check_in_date,
            $request->check_in_out,
            $request->guests,
            $request->rooms
        );

        // Handle pricing errors
        if (isset($prices['error'])) {
            return response()->json(['error' => $prices['error']], 400);
        }

        // Create booking
        $booking = Booking::create([
            'user_id' => $request->user_id,
            'room_id' => $request->room_id,
            'guests' => $request->guests,
            'rooms' => $request->rooms,
            'check_in_date' => $request->check_in_date,
            'check_in_out' => $request->check_in_out,
            'hotel_charges' => $prices['hotel_charges'],
            'discount' => $prices['discount'],
            'sub_total' => $prices['sub_total'],
            'taxes' => $prices['taxes'],
            'service_charge' => $prices['service_charge'],
            'total_price' => $prices['total_price'],
            'status' => $request->status ?? 'pending',
        ]);

        // dd($booking);

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Room booked successfully.',
            'booking' => $booking
        ], 201);
    }



    public function calculatePrice(Request $request)
    {

        dd($request->all());
        // Validate required fields
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'guests' => 'required|integer|min:1',
            'rooms' => 'required|integer|min:1',
        ]);

        // Calculate price
        $prices = PriceHelper::calculateTotalPrice(
            $request->room_id,
            $request->check_in_date,
            $request->check_out_date,
            $request->guests,
            $request->rooms
        );

        // Return calculated price
        return response()->json($prices);
    }



   
   

    public function userBookings(Request $request)
{
    // dd($request->all());
    $user = auth()->user();
    // dd($user);


    if (!$user) {
        return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
    }

    $bookings = Booking::with(['room.roomtype', 'room.hotel'])
        ->where('user_id', $user->id)
        ->latest()
        ->get();

        // dd($bookings);
    return response()->json([
        'bookings' => $bookings
    ]);
}

}
