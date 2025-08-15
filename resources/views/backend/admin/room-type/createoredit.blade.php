@extends('backend.admin-layouts.app')

@section('title', isset($roomType) ? 'Edit Room Type' : 'Create Room Type')

@section('content')
<div class="container mt-5">
    @if(session('success'))
        <div class="alert alert-success" role="alert" data-toggle="tooltip" title="{{ session('success') }}">
            <i class="fa fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    
    <h1>{{ isset($roomType) ? 'Edit Room Type' : 'Create Room Type' }}</h1>

    <form action="{{ isset($roomType) ? route('admin.room.createOrUpdate', $roomType->id) : route('admin.room.createOrUpdate') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name">{{ __('message.room_type_name') }}</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $roomType->name ?? '' }}" required>
        </div>

        <button type="submit" class="btn btn-dark">
            {{ isset($roomType) ? 'Update' : 'Create' }}{{ __('message.room_type') }}
        </button>
    </form>
</div>
@endsection

<script>
    $(document).ready(function() {
        // Enable tooltips
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
