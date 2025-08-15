<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Amenities;
use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\User;
use App\Models\PropertyType;
use Yajra\DataTables\Facades\DataTables;
  // In HotelController.php
  use App\Mail\HotelStatusUpdated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class HotelController extends Controller
{
    //
    public function show()
    {
        $hotel =  Hotel::all();
        $users = User::all();
        $amenities = Amenities::all();
        $propertyTypes = PropertyType::all();
        return view('backend.admin.hotels.index');
    }

    public function getHotel(Request $request)
    {
        if ($request->ajax()) {
            $query = Hotel::with('property_type');
            if ($request->has('name') && $request->name) {
                $query->where('name', 'LIKE', '%' . $request->name . '%');
            }

            return DataTables::eloquent($query)
                ->addColumn('action', function ($row) {
                    return view('backend.admin.hotels.action', compact('row'));
                })
                ->rawColumns(['action'])
                ->toJson();
        }
    }


    // In HotelController.php
    public function showDetails($id)
    {
        // Retrieve the hotel using the provided ID
        $hotel = Hotel::find($id);
        // dd($hotel);

        // Check if the hotel exists before calling methods on it
        if (!$hotel) {
            return response()->json(['message' => 'Hotel not found.'], 404);
        }

        // Assuming you want to get the images for the hotel:
        $images = $hotel->getMedia('images')->map(function ($media) {
            return $media->getUrl(); // or use other attributes like 'getFirstMediaUrl'
        }); // Adjust this to your actual image relationship and field name


        $map = json_decode($hotel->map, true); // Decode as an associative array

        // Check if map data exists and retrieve latitude and longitude
        $latitude = isset($map['latitude']) ? $map['latitude'] : null;
        $longitude = isset($map['longitude']) ? $map['longitude'] : null;



        // Return the hotel details as a response
        return response()->json([
            'name' => $hotel->name,
            'address' => $hotel->address,
            'email' => $hotel->email,
            'Phoneno' => $hotel->Phoneno,
            'city' => $hotel->city,
            'pincode' => $hotel->pincode,
            'telephoneno' => $hotel->telephoneno,
            'star_category' => $hotel->star_category,
            'website' => $hotel->website,
            'nearest_railwaystation' => $hotel->nearest_railwaystation,
            'nearest_airport' => $hotel->nearest_airport,
            'status' => $hotel->status,
            'description' => $hotel->description,
            'images' => $images,
            'latitude' => $latitude, // Return the latitude
            'longitude' => $longitude // Return the longitude
        ]);
    }


  
    
    public function updateStatus(Request $request)
    {
        $validated = $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'status' => 'required|in:pending,approved,rejected'
        ]);
    
        // Update hotel status
        $hotel = Hotel::findOrFail($validated['hotel_id']);
        $oldStatus = $hotel->status;  // Store old status to check if it changed
        $hotel->status = $validated['status'];
        $userName =Auth::user()->first_name;

        $hotel->save();
        // Send email to hotel owner if the status has changed to 'approved'
        if ($oldStatus !== $hotel->status && $hotel->status === 'approved') {
            Mail::to('mansiprajapati2711@gmail.com')->send(new HotelStatusUpdated($hotel, $hotel->status));
        }
    
        return response()->json(['success' => true]);
    }
    
}
