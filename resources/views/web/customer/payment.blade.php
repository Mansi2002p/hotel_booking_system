@extends('web.layouts.app')

@section('title', ' - Hotel Details')

@section('content')

<div class="container">
    <h2>Make Payment</h2>
    <form action="{{ route('payments.store') }}" method="POST">
        @csrf
        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

        <div class="mb-3">
            <label class="form-label">Total Amount</label>
            <input type="text" class="form-control" name="amount" value="{{ $booking->total_price }}" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Payment Method</label>
            <select class="form-control" name="payment_method" required>
                <option value="">Select Payment Method</option>
                {{-- <option value="credit_card">Credit Card</option> --}}
                <option value="paypal">PayPal</option>
                <option value="cash_on_delivery">Cash</option>
            </select>
        </div>

        <button type="submit" class="btn text-center mt-3" style="background-color: #dfa974; color: #fff;">Pay Now</button>
    </form>
</div>

<br>

@endsection
