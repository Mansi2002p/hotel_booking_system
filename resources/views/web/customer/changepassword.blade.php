
@extends('web.layouts.app')

@section('title', 'About Us')

@section('content')
<div class="container">
<form method="POST" action="{{ route('customer.change-password') }}">
    @csrf
    <div class="mb-3">
        <label for="current_password" class="form-label">Current Password</label>
        <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password">
        @error('current_password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="new_password" class="form-label">New Password</label>
        <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password">
        @error('new_password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation">
    </div>

    <button type="submit" class="btn mb-5" style="background-color:#dfa974;color:white;font-weight:300">Change Password</button>
</form>
</div>

@endsection