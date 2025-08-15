<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Booking;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;

class PayPalController extends Controller
{
    private $client;

    public function __construct()
    {
        $clientId = config('paypal.sandbox.client_id');
        $clientSecret = config('paypal.sandbox.client_secret');

        $environment = new SandboxEnvironment($clientId, $clientSecret);
        $this->client = new PayPalHttpClient($environment);
    }

    // ✅ Create Payment
    public function createPayment(Request $request)
    {
        $order = new OrdersCreateRequest();
        $order->prefer('return=representation');
        $order->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "amount" => [
                    "currency_code" => "USD",
                    "value" => $request->amount
                ],
                "description" => $request->description
            ]],
            "application_context" => [
                "cancel_url" => url('/api/paypal/cancel'),
                "return_url" => url('/api/paypal/execute-payment?booking_id=' . $request->booking_id)
            ]
        ];

        try {
            $response = $this->client->execute($order);

            // 🔗 Extract approval link
            foreach ($response->result->links as $link) {
                if ($link->rel === 'approve') {
                    return response()->json(['approve_url' => $link->href]);
                }
            }

            return response()->json(['error' => 'Approval link not found'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // ✅ Execute Payment
    public function executePayment(Request $request)
    {
        $orderId = $request->query('token');
        $bookingId = $request->query('booking_id');
        // ✅ Fetch user_id from booking if not passed
        $userId = $request->query('user_id');
        if (!$userId) {
            $booking = Booking::find($bookingId);
            if (!$booking) {
                return response()->json(['error' => 'Invalid Booking ID'], 400);
            }
            $userId = $booking->user_id;
        }

        $captureRequest = new OrdersCaptureRequest($orderId);

        try {
            $response = $this->client->execute($captureRequest);

            // 💾 Save Payment
            $payment = Payment::create([
                'user_id' => $userId,
                'booking_id' => $bookingId,
                'amount' => $response->result->purchase_units[0]->payments->captures[0]->amount->value,
                'payment_method' => 'paypal',
                'transaction_id' => $response->result->id,
                'status' => 'completed',
            ]);

            // ✅ Update Booking Status
            Booking::where('id', $bookingId)->update(['status' => 'confirm']);

            return response()->json(['status' => 'Payment Successful', 'payment' => $payment]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // ❌ Cancel Payment
    public function cancelPayment()
    {
        return response()->json(['status' => 'Payment Canceled by User']);
    }
}
