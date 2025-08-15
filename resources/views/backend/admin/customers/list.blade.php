@extends('backend.admin-layouts.app')

@section('title', 'Customer List')

@section('content')

<div class="container mt-5">
    <h1>Customer List</h1>
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

    <!-- Customer Table -->
    <table id="customerTable" class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Mobile Number</th>
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
    // get customer list
    $(document).ready(function() {
        // Destroy any existing DataTable before reinitializing
        if ($.fn.dataTable.isDataTable('#customerTable')) {
            $('#customerTable').DataTable().clear().destroy();
        }

        // Initialize DataTable for customer data
        var table = $('#customerTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.get-customers') }}",
                data: function(d) {
                    // Additional filters (optional)
                    d.name = $('#filterName').val();  // Example filter for customer name
                }
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'first_name', name: 'first_name' },
                { data: 'last_name', name: 'last_name' },
                { data: 'email', name: 'email' },
                { data: 'moblieno', name: 'moblieno' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
//  alert message
    toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-bottom-left", 
    "timeOut": "5000"
};
</script>

@endsection
