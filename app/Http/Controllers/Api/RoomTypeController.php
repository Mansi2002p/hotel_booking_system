<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoomTypeResource;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    //
    public function index(Request $request)
    {
        $room_type = RoomType::orderBy('name', 'asc')->get();
    
        return response()->json([
            'success' => true,
            'message' => 'Room type Type fetched successfully',
            'data' => RoomTypeResource::collection($room_type)
        ]);
    }
}
