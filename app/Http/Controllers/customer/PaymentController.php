<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Hotel;
use Illuminate\Http\Request;
use App\Models\Payment;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class PaymentController extends Controller
{
    //
    public function index($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        return view('web.customer.payment', compact('booking'));
    }



    protected $paypal;

    public function __construct()
    {
        $this->paypal = new PayPalClient;
        $this->paypal->setApiCredentials(config('paypal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:booking,id',
            'amount' => 'required|numeric',
            'payment_method' => 'required|string',
        ]);

        $booking = Booking::find($request->booking_id);
        $user = auth()->user();

        if (!$booking || !$user) {
            return back()->with('error', 'Booking or User not found.');
        }

        if ($request->payment_method == 'paypal') {
            // Use CSRF token as transaction_id
            return redirect()->route('paypal.payment', [
                'booking_id' => $booking->id,
       // Pass transaction_id
            ]);
        } else {
            // Store Payment with Transaction ID for other methods
            $payment = Payment::create([
                'booking_id' => $booking->id,
                'user_id' => $user->id,
                'amount' => $request->amount,
                'transaction_id' => $request->transaction_id,
                'payment_method' => 'cash',
                'status' => 'pending',
            ]);

            $booking->update(['status' => 'pending']);

            return redirect()->route('booking.confirmation', ['id' => $booking->id])
                ->with('success', 'Booking placed successfully! Please pay on arrival.');
        }
    }




    public function paypalPayment($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        Session::put('booking_id', $bookingId);

        // Get PayPal Access Token
        // dd($this->paypal->getAccessToken());
        $this->paypal->getAccessToken();

        // Create PayPal Order
        $response = $this->paypal->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.payment.success'),
                "cancel_url" => route('paypal.payment.cancel'),
            ],
            "purchase_units" => [[
                "amount" => [
                    "currency_code" => "USD",
                    "value" => $booking->total_price,
                ]
            ]]
        ]);

        // Debug the response (Uncomment for troubleshooting)
        // dd($response);

        // Check if order is created
        if (isset($response['id']) && $response['status'] === 'CREATED') {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        }

        return back()->with('error', 'Something went wrong with PayPal.');
    }


    // public function paypalSuccess(Request $request)
    // {
    //     $this->paypal->getAccessToken();
    //     $response = $this->paypal->capturePaymentOrder($request->query('token'));

    //     $bookingId = Session::pull('booking_id');
    //     $booking = Booking::find($bookingId);

    //     if (!$booking) {
    //         return redirect()->route('web.home')->with('error', 'Booking not found.');
    //     }

    //     if ($response['status'] === 'COMPLETED') {
    //         Payment::create([
    //             'booking_id' => $booking->id,
    //             'user_id' => auth()->id(),
    //             'amount' => $booking->total_price,
    //             'payment_method' => 'paypal',
    //             'status' => 'completed',
    //         ]);


    //         $booking->status = 'confirm';
    //         $booking->save();

    //         return redirect()->route('booking.confirmation')
    //             ->with('success', 'Payment successful! Your booking is confirmed.');
    //     }

    //     return redirect()->route('booking.details')
    //         ->with('error', 'Payment failed.');
    // }

    public function paypalSuccess(Request $request)
{
    // Get PayPal Access Token
    $this->paypal->getAccessToken();

    // Capture the PayPal payment using the token returned from PayPal
    $response = $this->paypal->capturePaymentOrder($request->query('token'));

    $bookingId = Session::pull('booking_id');
    $booking = Booking::find($bookingId);

    if (!$booking) {
        return redirect()->route('web.home')->with('error', 'Booking not found.');
    }

    // Check if the payment was completed
    if ($response['status'] === 'COMPLETED') {
        // Extract the PayPal transaction ID
        $transaction_id = $response['purchase_units'][0]['payments']['captures'][0]['id'];

        // Store the payment details, including the transaction ID
        Payment::create([
            'booking_id' => $booking->id,
            'user_id' => auth()->id(),
            'amount' => $booking->total_price,
            'transaction_id' => $transaction_id, // ✅ Store PayPal Transaction ID
            'payment_method' => 'paypal',
            'status' => 'completed',
        ]);

        // Update booking status to 'confirmed'
        $booking->status = 'confirm';
        $booking->save();

        return redirect()->route('booking.confirmation')
                         ->with('success', 'Payment successful! Your booking is confirmed.');
    }

    return redirect()->route('booking.details')
                     ->with('error', 'Payment failed.');
}

    public function paypalCancel()
    {
        $bookingId = Session::pull('booking_id');
        return redirect()->route('booking.details', $bookingId)
            ->with('error', 'Payment cancelled.');
    }



    public function confirmation()
    {
        $user = auth()->user(); // Get the authenticated user

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to view your bookings.');
        }

        // Fetch all bookings of the logged-in user with related room and hotel details
        $bookings = Booking::with(['room.roomtype', 'room.hotel'])
            ->where('user_id', $user->id)
            ->latest() // Order by latest booking
            ->paginate(4);

        // $payments = Payment::whereIn('booking_id', $bookings->pluck('id'))->get();

        return view('web.customer.booking_confirmation', compact('bookings'));
    }
}
