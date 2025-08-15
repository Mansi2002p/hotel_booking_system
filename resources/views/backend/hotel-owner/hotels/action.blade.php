<div class="btn-group">
    <!-- Hotel Details Button -->
    <button class="btn btn-sm btn-info detail-btn" data-id="{{ $row->id }}" data-name="{{ $row->name }}">
        <a href="{{route('owner.hotel.show', $row->id)}}"  style="text-decoration: none ; color:black"> View Details</a>  
   

    </button>
    
    <!-- Edit Button -->
    <button class="btn btn-sm btn-warning edit-btn" data-id="{{ $row->id }}" data-name="{{ $row->name }}"  style="margin-left: 10px">
        <a href="{{ route('owner.createOrEdit', $row->id) }}"  style="text-decoration: none ; color:black">
      Edit
        </a>
    </button>
    
    <!-- Delete Button -->
        <!-- Delete Button -->
        <form action="{{ route('owner.delete', $row->id) }}" method="POST" style="display:inline;"  onclick="return confirm('Are you sure you want to delete this?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $row->id }}" style="margin-left: 10px">
                Delete
            </button>
        </form>
</div>
