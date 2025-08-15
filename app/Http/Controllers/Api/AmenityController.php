<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Amenities;
use App\Http\Resources\AmenityResource;

class AmenityController extends Controller
{
    //
    public function index(Request $request)
    {
        $amenities = Amenities::orderBy('name', 'asc')->get();
    
        return response()->json([
            'success' => true,
            'message' => 'Amenities fetched successfully',
            'data' => AmenityResource::collection($amenities)
        ]);
    }
}
