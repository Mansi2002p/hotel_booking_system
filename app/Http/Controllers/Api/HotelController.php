<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\HotelResource;
use App\Models\Hotel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class HotelController extends Controller
{
    
public function createOrUpdate(Request $request)
{
    try {
        // ✅ Validate input
        $validated = $request->validate([
            'hotel_id' => 'nullable|exists:hotels,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'city' => 'required|string|max:255',
            'pincode' => 'required|string|max:10',
            'Phoneno' => 'required|string|max:15',
            'telephoneno' => 'nullable|string|max:15',
            'star_category' => 'required|integer|min:1|max:5',
            'email' => 'required|email|max:255',
            'website' => 'nullable|url|max:255',
            'nearest_railwaystation' => 'nullable|string|max:255',
            'nearest_airport' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'amenities' => 'required',
            'amenities.*' => 'exists:amenities,id',
            'property_type_id' => 'required|exists:property_type,id',
            'images' => 'nullable', // Remove 'array' to accept both single/multiple
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:pending,approved,rejected',

        ]);

        // ✅ Create or Update Hotel
        $hotel = Hotel::updateOrCreate(
            ['id' => $validated['hotel_id'] ?? null],
            [
                'name' => $validated['name'],
                'address' => $validated['address'],
                'description' => $validated['description'],
                'city' => $validated['city'],
                'pincode' => $validated['pincode'],
                'Phoneno' => $validated['Phoneno'],
                'telephoneno' => $validated['telephoneno'] ?? null,
                'star_category' => $validated['star_category'],
                'email' => $validated['email'],
                'website' => $validated['website'] ?? null,
                'nearest_railwaystation' => $validated['nearest_railwaystation'] ?? null,
                'nearest_airport' => $validated['nearest_airport'] ?? null,
                'latitude' => $validated['latitude'] ?? null,
                'longitude' => $validated['longitude'] ?? null,
                'property_type_id' => $validated['property_type_id'],
                'status' => 'pending',
                'user_id' => Auth::id(),
            ]
        );

        // ✅ Sync amenities
        $amenities = is_array($validated['amenities'])
            ? $validated['amenities']
            : explode(',', $validated['amenities']);
        $hotel->amenities()->sync($amenities);



        
        if ($request->hasFile('images')) {
            Log::info('Uploading images...', ['files' => $request->file('images')]);
            foreach ($request->file('images') as $image) {
                $hotel->addMedia($image)->toMediaCollection('images');
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => $hotel->wasRecentlyCreated ? 'Hotel created successfully' : 'Hotel updated successfully',
            'data' => new HotelResource($hotel->load(['amenities', 'media'])), // Load media
        ], 200);

    } catch (\Exception $e) {
        Log::error('Error creating or updating hotel:', ['error' => $e->getMessage()]);

        return response()->json([
            'success' => false,
            'message' => 'Failed to create or update hotel',
            'error' => $e->getMessage(),
        ], 500);
    }
}




public function getOwnerHotels()
{
    $user = Auth::user(); // ✅ Get logged-in user

    // ✅ Check if the user has the 'hotel_owner' role
    if ($user->hasRole('hotel_owner')) {

        // 🔄 Fetch only hotels owned by this user with amenities and media
        $hotels = Hotel::where('user_id', $user->id)->with('amenities', 'media')->get();




        return response()->json([
            'status' => 'success',
            'hotels' => HotelResource::collection($hotels), // ✅ Use Resource Collection
        ]);
    } else {
        return response()->json([
            'status' => 'error',
            'message' => 'Unauthorized access.'
        ], 403);
    }
}



public function hotelDelete(Request $request)
{
    $id = $request->id;

    $hotel = Hotel::find($id);
    if (!$hotel) {
        return response()->json([
            'status' => false,
            'message' => 'Room not found.'
        ], 404);
    }

    try {
        // ✅ Clear room images if using Media Library
        $hotel->clearMediaCollection('images');

        // ✅ Delete room
        $hotel->delete();

        return response()->json([
            'status' => true,
            'message' => 'Hotel deleted successfully.'
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to delete Hotel.',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function showHotelById(Request $request)
{
    try {
        $validated = $request->validate([
            'id' => 'required|integer|exists:hotels,id',
        ]);

        $hotel = Hotel::with('user')->findOrFail($validated['id']);
        // dd($hotel);
        // Ensure the user is authorized

        // if (Auth::user()->role === 'hotel_owner') {

        //     return response()->json(['error' => 'Unauthorized'], 403);
        // }

        return response()->json([
            'success' => true,
            'message' => 'Hotel Detail retrieved successfully',
            'data' => new HotelResource($hotel),
        ]);
    } catch (\Exception $e) {
        Log::error('Error fetching Hotel details:', ['error' => $e->getMessage()]);
        return response()->json([
            'success' => false,
            'message' => 'Post not found or invalid request',
        ], 404);
    }
}
}
