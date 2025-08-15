<?php

namespace App\Mail;

use App\Models\Hotel;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
USE Illuminate\Support\Facades\Auth;

class HotelStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $hotel;
    public $status;
    public $userName;

    /**
     * Create a new message instance.
     *
     * @param Hotel $hotel
     * @param string $status
     * @return void
     */
    public function __construct(Hotel $hotel, $status)
    {
        $this->hotel = $hotel;
        $this->status = $status;
        $this->userName = Auth::user()->first_name; 
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Hotel Status Updated')
                    ->view('emails.hotel_status_updated')
                    ->with([
                        'hotelName' => $this->hotel->name,
                        'status' => ucfirst($this->status),  
                        'userName' => $this->userName,
                        // Capitalizing the first letter of the status
                    ]);
    }
}
