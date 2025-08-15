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
    <h1 class="mt-5">{{ __('message.room_type_list') }}</h1>

    <!-- Add New Button -->
    <a href="{{ route('admin.room.createOrEdit') }}" class="btn" style="background-color:#212b36; color:white;">Add New Room Type</a>

    <!-- Property Types Table -->
    <table id="roomTable" class="table table-bordered">
        <thead>
            <tr>
                <th>{{ __('message.room_type_id') }}</th>
                <th>{{ __('message.room_type_name') }}</th>
                <th>{{ __('message.room_type_actions') }}</th>
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
    // get room type list
    $(document).ready(function() {
        // Destroy any existing DataTable before reinitializing
        if ($.fn.dataTable.isDataTable('#roomTable')) {
            $('#roomTable').DataTable().clear().destroy();
        }

        // Initialize DataTable
        var table = $('#roomTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.room-types') }}",
                data: function(d) {
                    // You can add additional filters here if needed
                    d.name = $('#filterName').val();  // Example of filtering by name (if a filter is applied)
                }
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
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
