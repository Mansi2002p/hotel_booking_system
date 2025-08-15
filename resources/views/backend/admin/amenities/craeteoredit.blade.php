@extends('backend.admin-layouts.app')

@section('title', 'Property Type List')

@section('content')
<div class="container mt-5">
    @if (session('success'))
    <script>
        $(document).ready(function() {
            toastr.success("{{ session('success') }}");
        });
    </script>
@endif

@if (session('error'))
    <script>
        $(document).ready(function() {
            toastr.error("{{ session('error') }}");
        });
    </script>
@endif


<h1 class="mt-5">{{ $amenities ? 'Edit Amenities' : 'Create Amenities' }}</h1>

        <form action="{{ route('admin.amenities.createOrUpdate', $amenities ? $amenities->id : '') }}" method="POST">
            @csrf
            @if($amenities)
                @method('POST') <!-- For the update case, this will send a POST request with the ID -->
            @else
                @method('POST') <!-- Will be treated as create, but same POST method -->
            @endif

            <div class="form-group">
                <label for="name"> {{ __('message.amenity_name') }} </label>
                <input type="text" name="name" id="name" class="form-control " value="{{ old('name', $amenities->name ?? '') }}" required>
             
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary" >
                    {{ $amenities ? 'Update Amenity' : 'Create Amenity' }}
                </button>
            </div>
        </form>
</div>
<script>
    
 
</script>
@endsection
