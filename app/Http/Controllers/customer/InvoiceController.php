<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\BookingConfirmedMail;
use Illuminate\Support\Facades\Mail;

class InvoiceController extends Controller
{
    //
    public function generateInvoice($id)
    {
        $booking = Booking::with(['room.roomtype', 'room.hotel', 'user'])->findOrFail($id);

        $pdf = Pdf::loadView('web.customer.invoice', compact('booking'));

        
// return view('web.customer.invoice', compact('booking'));
        return $pdf->download('invoice_' . $booking->id . '.pdf');
    }


    public function confirmBooking($id)
{
    $booking = Booking::findOrFail($id);
    $booking->status = 'confirm';
    $booking->save();

    // Send email with PDF
    Mail::to($booking->user->email)->send(new BookingConfirmedMail($booking));

    return redirect()->back()->with('success', 'Booking confirmed & email sent!');
}
}
