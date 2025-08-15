<a href="{{ route('admin.hotel-owner.edit', $row->id) }}" class="btn btn-primary btn-sm" style="text-decoration: none ; color:black">Edit</a>

<form action="{{ route('admin.hotel-owner.delete', $row->id) }}" method="GET" style="display:inline;">
    @csrf
    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this hotel owner?')">Delete</button>
</form>
