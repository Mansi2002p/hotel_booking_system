@extends('backend.hotel-owner-layouts.app')

@section('title', 'About Us')

@section('content')

<div class="container mt-5">
    @if(session('success'))
        <div class="alert alert-success" role="alert" data-toggle="tooltip" title="{{ session('success') }}">
            <i class="fa fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif


    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <h2 class="mt-5">{{ $hotel ? 'Edit Hotel' : 'Create Hotel' }}</h2>

    <form action="{{ route('owner.createOrUpdate', $hotel ? $hotel->id : '') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($hotel)
            @method('POST')
        @endif

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="name">{{ __('message.hotel_name') }}</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $hotel ? $hotel->name : '') }}" required>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="property_type_id">{{ __('message.hotel_property_type') }}</label>
                    <select name="property_type_id" id="property_type_id" class="form-select" required>
                        @foreach($propertyTypes as $propertyType)
                            <option value="{{ $propertyType->id }}" 
                                {{ old('property_type_id', $hotel ? $hotel->property_type_id : '') == $propertyType->id ? 'selected' : '' }}>
                                {{ $propertyType->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
        </div>
         
        </div>
        
        <div class="row">
     
            <div class="col-6">
                <div class="form-group">
                    <label for="amenities">{{ __('message.hotel_amenities') }}</label>
                      <select name="amenities[]" id="amenities" class="js-example-basic-multiple" multiple required>
                        @foreach($amenities as $amenity)
                            <option value="{{ $amenity->id }}" 
                                {{ in_array($amenity->id, old('amenities', $hotel ? $hotel->amenities->pluck('id')->toArray() : [])) ? 'selected' : '' }}>
                                {{ $amenity->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
              
            
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="address">{{ __('message.hotel_address') }}</label>
                    <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $hotel ? $hotel->address : '') }}" required>
                </div>
            </div>
        </div>
    

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="city">{{ __('message.hotel_city') }}</label>
                    <input type="text" name="city" id="city" class="form-control" value="{{ old('city', $hotel ? $hotel->city : '') }}" required>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="pincode">{{ __('message.hotel_pincode') }}</label>
                    <input type="text" name="pincode" id="pincode" class="form-control" value="{{ old('pincode', $hotel ? $hotel->pincode : '') }}" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="map">{{ __('message.hotel_late') }}</label>
                    <input type="text" name="latitude" id="latitude" class="form-control" value="{{ old('latitude', $hotel ? $hotel->latitude : '') }}">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="map">{{ __('message.hotel_long') }}</label>
                    <input type="text" name="longitude" id="longitude" class="form-control" value="{{ old('longitude', $hotel ? $hotel->longitude : '') }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="Phoneno">{{ __('message.hotel_phone_number') }}</label>
                    <input type="text" name="Phoneno" id="Phoneno" class="form-control" value="{{ old('Phoneno', $hotel ? $hotel->Phoneno : '') }}" required>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="telephoneno">{{ __('message.hotel_telephone_number') }}</label>
                    <input type="text" name="telephoneno" id="telephoneno" class="form-control" value="{{ old('telephoneno', $hotel ? $hotel->telephoneno : '') }}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="website">{{ __('message.hotel_website') }}</label>
                    <input type="url" name="website" id="website" class="form-control" value="{{ old('website', $hotel ? $hotel->website : '') }}">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="email">{{ __('message.hotel_email') }}</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $hotel ? $hotel->email : '') }}" required>
                </div>
            </div>
        </div>

        <div class="row">
           
            <div class="col-6">
                <div class="form-group">
                    <label for="star_category">{{ __('message.hotel_star_category') }}</label>
                    <input type="number" name="star_category" id="star_category" class="form-control" value="{{ old('star_category', $hotel ? $hotel->star_category : '') }}" required>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="nearest_railwaystation">{{ __('message.hotel_near_railwaystation') }}</label>
                    <input type="text" name="nearest_railwaystation" id="nearest_railwaystation" class="form-control" value="{{ old('nearest_railwaystation', $hotel ? $hotel->nearest_railwaystation : '') }}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="nearest_airport">{{ __('message.hotel_near_airport') }}</label>
                    <input type="text" name="nearest_airport" id="nearest_airport" class="form-control" value="{{ old('nearest_airport', $hotel ? $hotel->nearest_airport : '') }}">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="images">{{ __('message.hotel_image') }}</label>
                    <input type="file" name="images[]" id="images" class="form-control" multiple>
                    @if($hotel && $hotel->getMedia('images')->count())
                        <div class="mt-2">
                            @foreach($hotel->getMedia('images') as $image)
                                <img src="{{ $image->getUrl() }}" alt="Hotel Image" class="img-thumbnail" width="100">
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            
      
        </div>

        <div class="form-group">
            <label for="description">{{ __('message.hotel_descripition') }}</label>
            <textarea name="description" id="description" class="form-control" required>{{ old('description', $hotel ? $hotel->description : '') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">{{ $hotel ? 'Update Hotel' : 'Create Hotel' }}</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    var $j = jQuery.noConflict();
    $j(document).ready(function () {
        $j('.js-example-basic-multiple').select2();
    });

    $(document).ready(function() {
        // Enable tooltips
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endsection