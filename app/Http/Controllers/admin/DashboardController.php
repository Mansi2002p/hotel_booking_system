<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    //
    public function index(){
   
        return view('backend.admin.dashboard');
    }

    
    
    public function showHotelOwners()
    {
        return view('backend.admin.users.hotel_owner');
    }
    
    public function getHotelOwners(Request $request)
    {
        if ($request->ajax()) {
            $query = User::where('role', 'hotel_owner');
    
            // Apply filter if needed
            if ($request->has('name') && $request->name) {
                $query->where('first_name', 'LIKE', '%' . $request->name . '%')
                      ->orWhere('last_name', 'LIKE', '%' . $request->name . '%');
            }
    
            return DataTables::eloquent($query)
                ->addColumn('action', function ($row) {
                    return view('backend.admin.users.action', compact('row'));
                })
                ->rawColumns(['action'])  // To render action buttons (Edit, Delete)
                ->toJson();
        }
    }
    public function edit($id)
{
    $hotelOwner = User::findOrFail($id); // Find the hotel owner by ID
    return view('backend.admin.users.edit', compact('hotelOwner'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $id,
        'moblieno' => 'required|string|max:255',
        'address' => 'nullable|string|max:255',
        // Add validation rules for other fields as needed
    ]);

    $hotelOwner = User::findOrFail($id);  // Find the hotel owner by ID
    $hotelOwner->update($request->all()); // Update the hotel owner with new data

    return redirect()->route('admin.hotel-owners')->with('success', 'Hotel Owner updated successfully!');
}

    public function destroy($id)
{
    $hotelOwner = User::findOrFail($id); // Find the hotel owner by ID
    $hotelOwner->delete(); // Delete the hotel owner

    return redirect()->route('admin.hotel-owners')->with('success', 'Hotel Owner deleted successfully!');
}
public function showCustomers()
{
    // Return the view that will contain the DataTable for customers
    return view('backend.admin.customers.list');
}

public function getCustomers(Request $request)
{
    if ($request->ajax()) {
        // Fetch only customers (users with 'role' = 'customer')
        $query = User::where('role', 'customer');

        // You can add filters here if needed
        if ($request->has('name') && $request->name) {
            $query->where('first_name', 'LIKE', '%' . $request->name . '%')
                  ->orWhere('last_name', 'LIKE', '%' . $request->name . '%');
        }

        return DataTables::eloquent($query)
            ->addColumn('action', function ($row) {
                // Add edit and delete action buttons
                return view('backend.admin.customers.action', compact('row'));
            })
            ->rawColumns(['action'])  // To render the action buttons (Edit, Delete)
            ->toJson();
    }
}
public function editCustomer($id)
{
    $customer = User::findOrFail($id); // Find the customer by ID
    return view('backend.admin.customers.edit', compact('customer'));
}
public function updateCustomer(Request $request, $id)
{
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $id,
        'moblieno' => 'required|string|max:255',
        'address' => 'nullable|string|max:255',
        // Add validation rules for other fields as needed
    ]);

    $customer = User::findOrFail($id);  // Find the customer by ID
    $customer->update($request->all()); // Update the customer with new data

    return redirect()->route('admin.customers')->with('success', 'Customer updated successfully!');
}





    
    

}
