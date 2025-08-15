@extends('web.layouts.app')

@section('title', 'Profile Update')

@section('content')
<div class="container mt-5">
    <h1>Update Profile</h1>
    <form method="POST" action="{{ route('customer.updateProfile') }}">
        @csrf
        @method('POST')
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="fname" class="form-label">First Name</label>
                    <input type="text" class="form-control @error('fname') is-invalid @enderror" id="fname" name="fname" value="{{ old('fname', $user->first_name) }}">
                    @error('fname')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="lname" class="form-label">Last Name</label>
                    <input type="text" class="form-control @error('lname') is-invalid @enderror" id="lname" name="lname" value="{{ old('lname', $user->last_name) }}">
                    @error('lname')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="moblieno" class="form-label">Mobile No</label>
                    <input type="text" class="form-control @error('moblieno') is-invalid @enderror" id="moblieno" name="moblieno" value="{{ old('moblieno', $user->moblieno) }}">
                    @error('moblieno')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $user->address) }}">
                    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="zipcode" class="form-label">Zipcode</label>
                    <input type="text" class="form-control @error('zipcode') is-invalid @enderror" id="zipcode" name="zipcode" value="{{ old('zipcode', $user->zipcode) }}">
                    @error('zipcode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
        {{-- <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="country" class="form-label">Country</label>
                    <select class="form-select" name="country" id="country">
                        <option value="">Select a country...</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}" {{ old('country', $user->country_id) == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="state" class="form-label">State</label>
                    <select class="form-select" name="state" id="state">
                        <option value="">Select a state...</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="city" class="form-label">City</label>
                    <select class="form-select" name="city" id="city">
                        <option value="">Select a city...</option>
                    </select>
                </div>
            </div>
        </div> --}}
        <button type="submit" class="btn btn-primary mt-3 mb-3">Update Profile</button>
    </form>
</div>

<script>
//dynmically country,state and city dropown
// $(document).ready(function() {
//     $('#country').change(function() {
//         var countryId = $(this).val();
//         if (countryId) {
//             $.ajax({
//                 url: '/fetch-states',
//                 type: 'GET',
//                 data: { country_id: countryId },
//                 success: function(data) {
//                     $('#state').html('<option value="">Select a state...</option>');
//                     $.each(data.states, function(key, value) {
//                         $('#state').append('<option value="' + value.id + '">' + value.name + '</option>');
//                     });
//                 }
//             });
//         }
//     });

//     $('#state').change(function() {
//         var stateId = $(this).val();
//         if (stateId) {
//             $.ajax({
//                 url: '/fetch-cities',
//                 type: 'GET',
//                 data: { state_id: stateId },
//                 success: function(data) {
//                     $('#city').html('<option value="">Select a city...</option>');
//                     $.each(data.cities, function(key, value) {
//                         $('#city').append('<option value="' + value.id + '">' + value.name + '</option>');
//                     });
//                 }
//             });
//         }
//     });
// });


</script>
@endsection
