@extends('backend.admin-layouts.app')

@section('title', 'Hotel Owners List')

@section('content')

<div class="container mt-5">
    <h1>Hotel Owners List</h1>

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
    

    <!-- Hotel Owners Table -->
    <table id="hotelOwnersTable" class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Mobile Number</th>
                {{-- <th>City</th>
                <th>State</th> --}}
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be loaded via DataTables AJAX -->
        </tbody>
    </table>
</div>

<!-- Include jQuery and DataTables JS & CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
    // hotel-owner list fetch
    $(document).ready(function() {
        // Destroy any existing DataTable before reinitializing
        if ($.fn.dataTable.isDataTable('#hotelOwnersTable')) {
            $('#hotelOwnersTable').DataTable().clear().destroy();
        }

        // Initialize DataTable
        var table = $('#hotelOwnersTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.get-hotel-owners') }}",
                data: function(d) {
                    // You can add additional filters here if needed
                    d.name = $('#filterName').val();  // Example of filtering by name (if a filter is applied)
                }
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'first_name', name: 'first_name' },
                { data: 'last_name', name: 'last_name' },
                { data: 'email', name: 'email' },
                { data: 'moblieno', name: 'moblieno' },
                // { data: 'city', name: 'city' },
                // { data: 'state', name: 'state' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
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
