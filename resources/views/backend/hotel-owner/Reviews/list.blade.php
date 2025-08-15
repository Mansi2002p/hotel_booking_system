@extends('backend.hotel-owner-layouts.app')

@section('title', 'Profile Update')

@section('content')

<div class="container">

    <table id="reviewTable" class="table table-bordered">
        <thead>
            <tr>
    
                <th>Customer Name</th>
                <th>Hotel Name</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Date</th>
                {{-- <th>Action</th> --}}
            </tr>
        </thead>
    </table>
    
    <script>
    $(document).ready(function() {
        $('#reviewTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("reviews.list") }}', // Define this route
            columns: [
                { data: 'user', name: 'user' },
                // { data: 'hotels', name: 'hotels' },
                { data: 'hotel', name: 'hotel' },

                { data: 'rating', name: 'rating' },
                { data: 'comment', name: 'comment' },
                { data: 'created_at', name: 'created_at' },
                // { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
    </script>
    
</div>
@endsection