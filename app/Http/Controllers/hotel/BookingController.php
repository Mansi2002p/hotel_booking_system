<?php
namespace App\Http\Controllers\hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Yajra\DataTables\DataTables;

class BookingController extends Controller
{
    public function index()
    {
        return view('backend.hotel-owner.booking.list');
    }

    public function getBookings(Request $request)
    {
        if ($request->ajax()) {
            $bookings = Booking::with(['user', 'room.roomType'])->select('booking.*');

            return DataTables::of($bookings)
                ->addColumn('user', function ($booking) {
                    return $booking->user->first_name;
                })
                ->addColumn('room', function ($booking) {
                    // dd($booking->room->roomType->name);
                    return $booking->room->roomType->name;
                })
                ->addColumn('check_in', function ($booking) {
                    return $booking->check_in_date;
                })
                ->addColumn('check_out', function ($booking) {
                    return $booking->check_in_out;
                })
                ->addColumn('status', function ($booking) {
                    return ucfirst($booking->status);
                })
                ->addColumn('action', function ($booking) {
                    return '<button class="btn btn-info btn-sm viewBooking" data-id="'.$booking->id.'">View</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function bookingDetails(Request $request)
    {
        $booking = Booking::with(['user', 'room.roomType'])->findOrFail($request->id);
        return response()->json($booking);
    }
}
