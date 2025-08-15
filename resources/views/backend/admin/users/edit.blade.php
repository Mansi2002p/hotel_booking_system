@extends('backend.admin-layouts.app')

@section('title', 'Edit Hotel Owner')

@section('content')
    <div class="container mt-5">
        <h1>Edit Hotel Owner</h1>

        <form method="POST" action="{{ route('admin.hotel-owner.update', $hotelOwner->id) }}">
            @csrf
            @method('POST')

            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name', $hotelOwner->first_name) }}" required>
            </div>

            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name', $hotelOwner->last_name) }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $hotelOwner->email) }}" required>
            </div>

            <div class="form-group">
                <label for="moblieno">Mobile Number</label>
                <input type="text" name="moblieno" id="moblieno" class="form-control" value="{{ old('moblieno', $hotelOwner->moblieno) }}" required>
            </div>

            <button type="submit" class="btn btn-success mt-3">Save Changes</button>
        </form>
    </div>
@endsection
