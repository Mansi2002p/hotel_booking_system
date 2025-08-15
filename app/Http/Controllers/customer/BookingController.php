<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use App\Helpers\PriceHelper;
use App\Models\Hotel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{

    public function index(Request $request)
    {
        $rooms = Room::with(['hotel', 'roomType'])->get();

        // Check if room_id is provided in the URL
        $selectedRoom = null;
        if ($request->has('room_id')) {
            $selectedRoom = Room::with(['hotel', 'roomType'])->find($request->room_id);
        }

        return view('web.customer.booking', compact('rooms', 'selectedRoom'));
    }

    public function checkRoomAvailability(Request $request)
    {
        $roomId = $request->room_id;
        $checkin = Carbon::parse($request->checkin_date);
        $checkout = Carbon::parse($request->checkout_date);

        // Check if the room is already booked within the requested period
        $isBooked = Booking::where('room_id', $roomId)
            ->where(function ($query) use ($checkin, $checkout) {
                $query->whereBetween('check_in_date', [$checkin, $checkout])
                    ->orWhereBetween('check_in_out', [$checkin, $checkout])
                    ->orWhere(function ($query) use ($checkin, $checkout) {
                        $query->where('check_in_date', '<=', $checkin)
                            ->where('check_in_out', '>=', $checkout);
                    });
            })
            ->exists();

        if ($isBooked) {
            return response()->json(['error' => 'Room is already booked for the selected date and Time .'], 400);
        }

        return response()->json(['available' => true]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'checkin_date' => 'required|date',
            'checkout_date' => 'required|date|after:checkin_date',
            'guests' => 'required|integer|min:1',
            'rooms' => 'required | integer | min:1'
        ]);

        $prices = PriceHelper::calculateTotalPrice(
            $request->room_id,
            $request->checkin_date,
            $request->checkout_date,
            $request->guests,
            $request->rooms
        );

        if (isset($prices['error'])) {
            return response()->json(['error' => $prices['error']], 400);
        }


        $booking = Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $request->room_id,
            'check_in_date' => $request->checkin_date,
            'check_in_out' => $request->checkout_date,  // Ensure the request contains this field
            'guests' => $request->guests,
            'hotel_charges' => $prices['hotel_charges'],
            'discount' => $prices['discount'],
            'sub_total' => $prices['sub_total'],
            'taxes' => $prices['taxes'],
            'service_charge' => $prices['service_charge'],
            'total_price' => $prices['total_price'],
            'status' => $request->status ?? 'pending',
            'rooms' => $request->rooms, // Store the number of rooms
        ]);


        return response()->json([
            'success' => true,
            'message' => 'Room booked successfully.',
            'booking_id' => $booking->id
        ]);
    }

    public function calculatePrice(Request $request)
    {
        $data = PriceHelper::calculateTotalPrice(
            $request->room_id,
            $request->checkin_date,
            $request->checkout_date,
            $request->guests,
            $request->rooms // Add rooms here
        );

        return response()->json($data);
    }


    public function show(Request $request, $id)
    {
        $booking = Booking::with('room', 'user')->find($id);
        $hotel = Hotel::find($booking->room->hotel_id);
        if ($request->hasFile('image')) {
            $hotel->addMediaFromRequest('image')->toMediaCollection('images');
        }

        return view('web.customer.booking_details', compact('booking', 'hotel'));
    }

    public function cancelBooking(Request $request)
    {
        // Find the booking by ID
        $booking = Booking::find($request->id);

        // Check if booking exists
        if (!$booking) {
            return response()->json(['success' => false, 'message' => 'Booking not found.']);
        }

        // Update status and cancellation date
        $booking->status = 'cancel';
        $booking->cancellation_date = now();  // Store the current date and time as cancellation date
        $booking->save();

        // Optionally: You can also log this cancellation in a separate table like BookingCancellation
        // Return booking ID in response
        return response()->json([
            'success' => true,
            'message' => 'Booking cancelled successfully.',
            'booking_id' => $booking->id  // Include booking ID in response
        ]);

        // return response()->json(['success' => true, 'message' => 'Booking cancelled successfully.']);
    }
}
