<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    //
    public function changeProfile(Request $request)
    {
    //  dd($request->all());
        $user = auth()->user(); // Get authenticated user
        
        $validator = Validator::make($request->all(), [
            'first_name'  => 'required|string|max:255',
            'last_name'   => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . $user->id,
            'moblieno'    => 'nullable|string|max:15',
            'address'     => 'nullable|string',
            'zipcode'     => 'nullable|string|max:10',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // ✅ Update user details
        $user->update($validator->validated());
    
     
    
        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully',
            'user' => $user,
        ], 200);
    }




// public function getCustomerList()
// {
//     $customers = User::role('customer')->get(); // ✅ Using Spatie's role method

//     if ($customers->isEmpty()) {
//         return response()->json(['message' => 'No customers found.'], 404);
//     }

//     return response()->json([
//         'status' => true,
//         'customers' => $customers
//     ], 200);
// }

public function getCustomerList()
{
    // Get authenticated user
    $user = auth()->user();

    // if ($user->hasRole(['hotel_owner', 'admin'])) {
        // Admins and Hotel Owners get the full customer list
        $customers = User::where('role', 'customer')->get();


        if ($customers->isEmpty()) {
            return response()->json(['message' => 'No customers found.'], 404);
        }

        return response()->json([
            'status' => true,
            'customers' => $customers
        ], 200);
    // } elseif ($user->hasRole('customer')) {
        // Customers can only see their own profile
        return response()->json([
            'status' => true,
            'customer' => $user
        ], 200);
    // }

    // If the user has none of the expected roles
    return response()->json(['message' => 'Unauthorized'], 403);
}


public function getHotelownerList()
{
    // Get authenticated user
    $user = auth()->user();

    // if ($user->hasRole(['hotel_owner', 'admin'])) {
        // Admins and Hotel Owners get the full customer list
        $hotelowner = User::where('role', 'hotel_owner')->get();


        if ($hotelowner->isEmpty()) {
            return response()->json(['message' => 'No Hotel owner found.'], 404);
        }

        return response()->json([
            'status' => true,
            'Hotel_Owner' => $hotelowner
        ], 200);
    // } elseif ($user->hasRole('customer')) {
        // Customers can only see their own profile
        return response()->json([
            'status' => true,
            'Hotel_Owner' => $user
        ], 200);
    // }

    // If the user has none of the expected roles
    return response()->json(['message' => 'Unauthorized'], 403);
}

    
}
