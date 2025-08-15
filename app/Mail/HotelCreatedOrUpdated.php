<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

use App\Models\Hotel;
class HotelCreatedOrUpdated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $hotel;
    public $userName;
    public $message; 
    public function __construct(Hotel $hotel , string $message)
    {
        //
        $this->hotel = $hotel;
        $this->userName = Auth::user()->first_name; // Get the logged-in user's name
        $this->message = (string)$message ; 
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Hotel Created Or Updated',
        );
    }

    /**
     * Get the message content definition.
     */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
    public function build()
    {
        return $this->subject('Hotel Created/Updated')
        ->view('emails.hotel-created-or-updated')
        ->with([
            'hotelName' => $this->hotel->name,
            'hotelAddress' => $this->hotel->address,
            'hotelCity' => $this->hotel->city,
            'userName' => $this->userName,
            'message' =>  htmlspecialchars($this->message, ENT_QUOTES, 'UTF-8'), // Ensure it's a safe string
        ]);
}
}
