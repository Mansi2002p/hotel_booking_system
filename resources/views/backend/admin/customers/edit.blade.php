@extends('backend.admin-layouts.app')

@section('title', 'Edit Customer')

@section('content')
    <div class="container mt-5">
        <h1>{{ __('message.customer_edits') }}</h1>

        <form method="POST" action="{{ route('admin.customer.update', $customer->id) }}">
            @csrf
            @method('POST')

            <div class="form-group">
                <label for="first_name">{{ __('message.customer_fname') }}</label>
                <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name', $customer->first_name) }}" required>
            </div>

            <div class="form-group">
                <label for="last_name">{{ __('message.customer_lname') }}</label>
                <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name', $customer->last_name) }}" required>
            </div>

            <div class="form-group">
                <label for="email">{{ __('message.customer_email') }}</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $customer->email) }}" required>
            </div>

            <div class="form-group">
                <label for="moblieno">{{ __('message.customer_phone') }}</label>
                <input type="text" name="moblieno" id="moblieno" class="form-control" value="{{ old('moblieno', $customer->moblieno) }}" required>
            </div>

            <button type="submit" class="btn btn-success mt-3">{{ __('message.customer_save') }}</button>
        </form>
    </div>
@endsection

