<?php
namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingConfirmedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function build()
    {
        $pdf = Pdf::loadView('pdf.invoice', ['booking' => $this->booking])->output();

        return $this->subject('Your Booking Confirmation')
                    ->view('emails.booking_confirmed')
                    ->attachData($pdf, 'invoice_' . $this->booking->id . '.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
