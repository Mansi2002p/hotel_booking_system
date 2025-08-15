@extends('backend.admin-layouts.app')

@section('title', 'Property Type List')

@section('content')

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
    <!-- Table for displaying hotels -->
    <table class="table table-bordered" id="hotelTable">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('message.h_name') }}</th>
                <th>{{ __('message.h_address') }}</th>
                <th>{{ __('message.h_email') }}</th>
                <th>{{ __('message.h_phone') }}</th>
                <th>{{ __('message.h_status') }}</th>
                <th>{{ __('message.h_actions') }}</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be populated by DataTables -->
        </tbody>
    </table>
</div>

<!-- Include jQuery & DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script> 
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<script>
    // get hotel basic detials
    $(document).ready(function () {
        // Initialize DataTable
        var table = $('#hotelTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin.getHotel') }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'address', name: 'address' },
                { data: 'email', name: 'email' },
                { data: 'Phoneno', name: 'Phoneno' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            // Modify row after it is created
            createdRow: function (row, data, dataIndex) {
                // Add a dropdown to the status column
                var statusDropdown = '<select class="status-dropdown" data-id="' + data.id + '">';
                statusDropdown += '<option value="pending" ' + (data.status === 'pending' ? 'selected' : '') + '>Pending</option>';
                statusDropdown += '<option value="approved" ' + (data.status === 'approved' ? 'selected' : '') + '>Approved</option>';
                statusDropdown += '<option value="rejected" ' + (data.status === 'rejected' ? 'selected' : '') + '>Rejected</option>';
                statusDropdown += '</select>';
                // Append the dropdown to the status column
                $('td:eq(5)', row).html(statusDropdown);
            }
        });

        // Handle status change
        $('#hotelTable').on('change', '.status-dropdown', function () {
            var hotelId = $(this).data('id');
            var newStatus = $(this).val();

            // Send an AJAX request to update the status
            $.ajax({
                url: '{{ route('admin.updateHotelStatus') }}',  // Route to handle status update
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    hotel_id: hotelId,
                    status: newStatus
                },
                success: function(response) {
                    // Optionally, you can show a success message or update the UI
                    alert('Status updated successfully!');
                    // Reload the table to reflect changes
                    table.ajax.reload();
                },
                error: function() {
                    alert('Error updating status!');
                }
            });
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
