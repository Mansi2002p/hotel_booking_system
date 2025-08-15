<?php

namespace App\Http\Controllers\hotel;

use App\Http\Controllers\Controller;
use App\Models\Amenities;
use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\PropertyType;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Mail\HotelCreatedOrUpdated;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Support\Facades\Mail;

class HotelsController extends Controller
{
    public function createOrEdit($id = null)
    {
        $hotel = $id ? Hotel::findOrFail($id) : null;
        $users = User::all();
        $amenities = Amenities::all();
        $propertyTypes = PropertyType::all();

        return view('backend.hotel-owner.hotels.createoredit', compact('hotel', 'users', 'amenities', 'propertyTypes'));
    }

    public function createOrUpdate(Request $request, $id = null)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'city' => 'required|string|max:255',
            'pincode' => 'required|string|max:10',
            'Phoneno' => 'required|integer',
            'telephoneno' => 'nullable|integer',
            'star_category' => 'required|integer|min:1|max:5',
            'email' => 'required|email|max:255',
            'website' => 'nullable|url|max:255',
            'nearest_railwaystation' => 'nullable|string|max:255',
            'nearest_airport' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric', // Validate latitude
            'longitude' => 'nullable|numeric', // Validate longitude
            'amenities' => 'required|array',
            'property_type_id' => 'required|exists:property_type,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $mapData = null;
        if ($validated['latitude'] && $validated['longitude']) {
            $mapData = json_encode([
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
            ]);
        }

        $hotelData = [
            'name' => $validated['name'],
            'address' => $validated['address'],
            'description' => $validated['description'],
            'city' => $validated['city'],
            'pincode' => $validated['pincode'],
            'Phoneno' => $validated['Phoneno'],
            'telephoneno' => $validated['telephoneno'],
            'star_category' => $validated['star_category'],
            'email' => $validated['email'],
            'website' => $validated['website'],
            'nearest_railwaystation' => $validated['nearest_railwaystation'],
            'nearest_airport' => $validated['nearest_airport'],
            'map' => $mapData,    // Added longitude
            'property_type_id' => $validated['property_type_id'],
            'user_id' => Auth::id(),

        ];

        $hotel = Hotel::updateOrCreate(['id' => $id], $hotelData);
        $hotel->amenities()->sync($validated['amenities']);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $hotel->addMedia($image)->toMediaCollection('images');
            }
        }
        $message = $id ? 'A hotel has been updated by ' . Auth::user()->first_name . '.'
            : 'A new hotel has been created by ' . Auth::user()->first_name . '.';

        Mail::to('mansiprajapati2711@gmail.com')->send(new HotelCreatedOrUpdated($hotel, $message));
        return redirect()->route('owner.index')->with('success', $hotel ? 'Hotel updated successfully!' : 'Hotel created successfully!');
    }

    public function index()
    {
        return view('backend.hotel-owner.hotels.list');
    }

    public function getHotels(Request $request)
    {
        if ($request->ajax()) {
            $query = Hotel::with('property_type');
            if ($request->has('name') && $request->name) {
                $query->where('name', 'LIKE', '%' . $request->name . '%');
            }

            return DataTables::eloquent($query)
                ->addColumn('action', function ($row) {
                    return view('backend.hotel-owner.hotels.action', compact('row'));
                })
                ->rawColumns(['action'])
                ->toJson();
        }
    }

    // public function show($id)
    // {
    //     $hotel = Hotel::with('rooms.roomType')->findOrFail($id);
    //     // dd($hotel);
    //     $roomsLimited = $hotel->rooms->take(4);
    //     // dd($roomsLimited);
    //     return view('backend.hotel-owner.hotels.detail', compact('hotel', 'roomsLimited'));
    // }


    public function show($id)
    {
        $hotel = Hotel::with(['rooms.roomType', 'amenities'])->findOrFail($id);
        $roomsLimited = $hotel->rooms->take(4);

        return view('backend.hotel-owner.hotels.detail', compact('hotel', 'roomsLimited'));
    }
    public function allRooms($hotelId)
    {
        // Find the hotel by ID
        $hotel = Hotel::with('rooms')->findOrFail($hotelId);

        // Pass the hotel with its rooms to the view
        return view('backend.hotel-owner.hotels.all-rooms', compact('hotel'));
    }

    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id); // Find the property type by ID

        // Delete the property type
        $hotel->delete();

        // Redirect back to the property list page with a success message
        return redirect()->route('owner.index')->with('success', 'Hotel sucessfully  Deleted Successfully');
    }




    public function filterRooms(Request $request)
    {
        $hotelId = $request->hotel_id;
        $roomType = $request->roomtype_id;
        $status = $request->status;
        $airCondition = $request->air_conditon;

        $rooms = Room::where('hotels_id', $hotelId)
            ->when($roomType, function ($query) use ($roomType) {
                return $query->where('roomtype_id', $roomType);
            })
            ->when($status, function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->when(isset($airCondition), function ($query) use ($airCondition) {
                return $query->where('air_conditon', $airCondition);
            })
            ->with(['roomType', 'media'])
            ->get();

        return response()->json($rooms);
    }

    // Get all room types for the dropdown
    public function getRoomTypes()
    {
        $roomTypes = RoomType::all();
        return response()->json($roomTypes);
    }

    public function getRoomStatuses()
    {
        $statuses = Room::distinct()->pluck('status');
        return response()->json($statuses);
    }
    public function getAcOptions()
    {
        $acOptions = Room::distinct()->pluck('air_conditon');
        return response()->json($acOptions);
    }
}
