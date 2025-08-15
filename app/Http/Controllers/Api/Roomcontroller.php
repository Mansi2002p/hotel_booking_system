<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Http\Resources\RoomResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class Roomcontroller extends Controller
{
    //
    public function index()
    {
        $rooms = Room::with(['hotel', 'roomType', 'amenities', 'media'])->get();
        return response()->json(RoomResource::collection($rooms));
    }

    // // Add or Update Room
    // public function storeOrUpdate(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'id' => 'nullable|exists:rooms,id',
    //         'room_no' => 'required|string|max:255',
    //         'roomtype_id' => 'required|exists:room_type,id',
    //         'hotels_id' => 'required|exists:hotels,id',
    //         'price' => 'required|numeric',
    //         'air_conditon' => 'required ',
    //         'bed_capacity' => 'required|integer',
    //         'decsription' => 'nullable|string',
    //         'room_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     $room = Room::updateOrCreate(
    //         ['id' => $request->id],
    //         $request->only(['room_no', 'roomtype_id', 'hotels_id', 'price', 'air_conditon', 'bed_capacity', 'decsription'])
    //     );
        
    //     // ✅ Sync amenities
    //     $amenities = is_array($validator['amenities'])
    //         ? $validator['amenities']
    //         : explode(',', $validator['amenities']);
    //     $room->amenities()->sync($amenities);

    //     // Handle Room Images
    //     if ($request->hasFile('room_images')) {
    //         $room->clearMediaCollection('room_images');
    //         foreach ($request->file('room_images') as $image) {
    //             $room->addMedia($image)->toMediaCollection('room_images');
    //         }
    //     }

    //     return response()->json(['message' => 'Room saved successfully', 'room' => new RoomResource($room)], 200);
    // }

    public function storeOrUpdate(Request $request)
{
    // ✅ Validate input data
    $validator = Validator::make($request->all(), [
        'id' => 'nullable|exists:rooms,id',
        'room_no' => 'required|string|max:255',
        'roomtype_id' => 'required|exists:room_type,id', // Fixed table name
        'hotels_id' => 'required|exists:hotels,id',
        'price' => 'required|numeric',
      'air_conditon' => 'required|in:Ac,Non Ac',

        'bed_capacity' => 'required|integer',
        'decsription' => 'nullable|string',
        'amenities' => 'required',
        'amenities.*' => 'required|integer|exists:amenities,id',
        'room_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $validated = $validator->validated();

    // ✅ Create or Update Room
    $room = Room::updateOrCreate(
        ['id' => $validated['id'] ?? null],
        [
            'room_no' => $validated['room_no'],
            'roomtype_id' => $validated['roomtype_id'],
            'hotels_id' => $validated['hotels_id'],
            'price' => $validated['price'],
            'air_conditon' => $validated['air_conditon'], // 'Ac' or 'Non Ac'
            'bed_capacity' => $validated['bed_capacity'],
            'decsription' => $validated['decsription'] ?? null,
        ]
    );

    // dd($room);

    // ✅ Sync Amenities
        // ✅ Ensure amenities are integers and valid
        $amenities = is_array($validated['amenities'])
        ? $validated['amenities']
        : explode(',', $validated['amenities']);
        $room->amenities()->sync($amenities);

    // // ✅ Handle Room Images
    // if ($request->hasFile('room_images')) {
          
    //     foreach ($request->file('room_images') as $image) {
    //         $room->addMedia($image)->toMediaCollection('room_images');
    //     }
    // }
 // ✅ Handle Media Upload using Helper
if ($request->hasFile('room_images')) {
    $room->clearMediaCollection('room_images'); // Clear existing images if updating
    foreach ($request->file('room_images') as $image) {
        storeRoomImage($image, $room); // Using helper
    }
}



    return response()->json([
        'message' => $room->wasRecentlyCreated ? 'Room created successfully' : 'Room updated successfully',
        'room' => new RoomResource($room->load(['hotel', 'roomType', 'amenities', 'media'])),
    ], 200);
}


public function roomDelete(Request $request)
{
    $id = $request->id;
    // dd($id);
    $room = Room::find($id);

    if (!$room) {
        return response()->json([
            'status' => false,
            'message' => 'Room not found.'
        ], 404);
    }

    try {
        // ✅ Clear room images if using Media Library
        $room->clearMediaCollection('room_images');

        // ✅ Delete room
        $room->delete();

        return response()->json([
            'status' => true,
            'message' => 'Room deleted successfully.'
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to delete room.',
            'error' => $e->getMessage()
        ], 500);
    }
}


public function showRoomById(Request $request)
{
    try {
        $validated = $request->validate([
            'id' => 'required|integer|exists:rooms,id',
        ]);

        $room = Room::findOrFail($validated['id']);
        

        return response()->json([
            'success' => true,
            'message' => 'Room Detail retrieved successfully',
            'data' => new RoomResource($room),
        ]);
    } catch (\Exception $e) {
        Log::error('Error fetching Hotel details:', ['error' => $e->getMessage()]);
        return response()->json([
            'success' => false,
            'message' => 'Room not found or invalid request',
        ], 404);
    }
}

}
