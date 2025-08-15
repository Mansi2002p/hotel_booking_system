<a href="{{ route('admin.customer.edit', $row->id) }}" class="btn btn-primary btn-sm" style="text-decoration: none ; color:black">{{ __('message.customer_edit') }}</a>

<form action="{{ route('admin.customer.delete', $row->id) }}" method="GET" style="display:inline;">
    @csrf
    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this customer?')">{{ __('message.customer_delete') }}</button>
</form>
