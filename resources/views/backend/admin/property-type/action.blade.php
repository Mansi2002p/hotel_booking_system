<div class="btn-group">
    <!-- Edit Button -->
    <button class="btn btn-sm btn-warning edit-btn" data-id="{{ $row->id }}" data-name="{{ $row->name }}">
        <a href="{{ route('admin.property.edit', $row->id) }}"  style="text-decoration: none ; color:black">
            {{ __('message.property_type_edit') }}
        </a>
    </button>
    
    <!-- Delete Button -->
    <form action="{{ route('admin.property.delete', $row->id) }}" method="POST" style="display:inline;"  onclick="return confirm('Are you sure you want to delete this?')">
        @csrf
        @method('DELETE')
        <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $row->id }}" style="margin-left: 10px">
            {{ __('message.property_type_delete') }}
        </button>
    </form>
</div>
