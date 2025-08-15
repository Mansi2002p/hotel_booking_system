<?php

namespace App\Http\Controllers\hotel;

use App\Http\Controllers\Controller;
use App\Models\Amenities;
use Illuminate\Http\Request;
use App\Models\Room;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Hotel;
use App\Models\RoomType;

class RoomsController extends Controller
{
    //
    public function index()
    {
        return view('backend.hotel-owner.rooms.list');
    }

    // public function getRooms(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $query = Room::with('hotel', 'roomType' ,'amenities');

    //         return DataTables::eloquent($query)
    //             ->addColumn('room_images', function ($room) {
    //                 $images = $room->getMedia('room_images');
    //                 $imageUrls = $images->map(function ($image) {
    //                     return '<img src="' . $image->getUrl('') . '" width="50" height="50">';
    //                 })->implode(' '); // Concatenating images with space

    //                 return $imageUrls ?: 'No Image';
    //             })
    //             ->addColumn('action', function ($row) {
    //                 return view('backend.hotel-owner.rooms.action', compact('row'));
    //             })
    //             ->rawColumns(['images', 'action']) // Ensure images are not escaped
    //             ->toJson();
    //     }
    // }

    public function getRooms(Request $request)
{
    if ($request->ajax()) {
        $query = Room::with(['hotel', 'roomType', 'amenities']);

        return DataTables::eloquent($query)
            ->addColumn('room_images', function ($room) {
                $images = $room->getMedia('room_images');
                $imageUrls = $images->map(function ($image) {
                    return '<img src="' . $image->getUrl('') . '" width="50" height="50">';
                })->implode(' ');

                return $imageUrls ?: 'No Image';
            })
            ->addColumn('amenities', function ($room) {
                $allAmenities = $room->amenities->pluck('name')->toArray();
                $limitedAmenities = array_slice($allAmenities, 0, 2); // Show only 2 amenities
                return implode(', ', $limitedAmenities) . (count($allAmenities) > 2 ? '...' : '');
            })
            
            ->addColumn('action', function ($row) {
                return view('backend.hotel-owner.rooms.action', compact('row'));
            })
            ->rawColumns(['room_images', 'action'])
            ->toJson();
    }
}



    public function createOrEdit($id = null)
    {
        $room = $id ? Room::with('amenities')->findOrFail($id) : null;
        $hotels = Hotel::all();
        $roomTypes = RoomType::all();
        $amenities = Amenities::all(); // Fetch all amenities
    
        return view('backend.hotel-owner.rooms.createoredit', compact('room', 'hotels', 'roomTypes', 'amenities'));
    }
    

    public function createOrUpdate(Request $request, $id = null)
    {
        $validated = $request->validate([
            'room_no' => 'required|integer',
            'roomtype_id' => 'required|exists:room_type,id',
            'hotels_id' => 'required|exists:hotels,id',
            'price' => 'required|numeric',
            'air_conditon' => 'required|string',
            'bed_capacity' => 'required|integer',
            'decsription' => 'required|string',  
            'amenities' => 'required|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,gif',
        ]);

        $room = Room::updateOrCreate(['id' => $id], $validated);
            // Sync amenities if provided
            if ($request->has('amenities')) {
                $room->amenities()->sync($validated['amenities']);
            }
    

        // Check if images were uploaded and add them to the room
        if ($request->hasFile('room_images')) {
            foreach ($request->file('room_images') as $image) {
                $room->addMedia($image)
                    ->preservingOriginal()
                    ->toMediaCollection('room_images'); // Store in the 'room_images' collection
            }
        }


        return redirect()->route('rooms.index')->with(['success' => $id ? 'Room updated successfully!' : 'Room created successfully!']);
    }




    public function show($id)
    {
        $room = Room::with('hotel', 'roomType' , 'amenities')->findOrFail($id);
        if (!$room) {
            return response()->json(['message' => 'Room not found.'], 404);
        }
        return response()->json($room);
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();
        return redirect()->route('rooms.index')->with(['success' => 'Room deleted successfully!']);
    }
}
