@extends('backend.admin-layouts.app')

@section('title', isset($propertyType) ? 'Edit Property Type' : 'Create Property Type')

@section('content')
<div class="container mt-5">
    @if(session('success'))
    <div class="alert alert-success" role="alert" data-toggle="tooltip" title="{{ session('success') }}">
        <i class="fa fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

    <h1>{{ isset($propertyType) ? 'Edit Property Type' : 'Create Property Type' }}</h1>

    <form action="{{ isset($propertyType) ? route('admin.property.createOrUpdate', $propertyType->id) : route('admin.property.createOrUpdate') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name">{{ __('message.property_type_name') }}</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $propertyType->name ?? '') }}" required>
        </div>

        <button type="submit" class="btn" style="background-color:#212b36; color:white;">
            {{ isset($propertyType) ? 'Update' : 'Create' }}{{ __('message.property_type') }}
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