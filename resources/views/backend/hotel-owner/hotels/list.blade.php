@extends('backend.hotel-owner-layouts.app')

@section('title', 'Hotel List')

@section('content')

<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<!-- jQuery (Required for Toastr) -->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<div class="container mt-5">
    <h2 class="mt-5">Hotels</h2>
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

        <!-- Add New Button -->
        <a href="{{ route('owner.createOrEdit') }}" class="btn" style="background-color:#212b36; color:white;">Add New Hotel</a>
    <!-- Table for displaying hotels -->
    <table class="table table-bordered" id="hotelTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Address</th>
                <th>Email</th>
                <th>Phone No</th>
         
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be populated by DataTables -->
        </tbody>
    </table>
</div>



<script>
$('#hotelTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route('owner.getHotels') }}',
    columns: [
        { data: 'id', name: 'id' },
        { data: 'name', name: 'name' },
        { data: 'address', name: 'address' },
        { data: 'email', name: 'email' },
        { data: 'Phoneno', name: 'Phoneno' },
    
        { data: 'status', name: 'status' },
        { data: 'action', name: 'action', orderable: false, searchable: false }
    ]
});

    // alert message
    toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-bottom-left", 
    "timeOut": "5000"
};

</script>

@endsection