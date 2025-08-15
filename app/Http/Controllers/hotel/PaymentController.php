<?php

namespace App\Http\Controllers\hotel;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
class PaymentController extends Controller
{
    //
    public function showPayment(){

        $payment = Payment::get();
        return view('backend.hotel-owner.payment.list', compact('payment'));
    }





public function getPayments(Request $request)
{
    if ($request->ajax()) {
        $query = Payment::with('booking.user', 'booking.room');

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        return DataTables::eloquent($query)
            ->addColumn('user', function ($payment) {
                return $payment->booking->user->first_name ?? 'N/A';
            })
            ->addColumn('room', function ($payment) {
                return $payment->booking->room->room_no ?? 'N/A';
            })
            ->addColumn('amount', function ($payment) {
                return  number_format($payment->amount, 2);
            })
            ->addColumn('status', function ($payment) {
                return ucfirst($payment->status);
            })
            ->addColumn('transaction_id', function ($payment) {
                return ucfirst($payment->transaction_id ?? 'N/A');
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}

}
