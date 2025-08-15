<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Property_typeResource;
use App\Models\PropertyType;
use Illuminate\Http\Request;

class PropertyTypeController extends Controller
{
    //
    public function index(Request $request)
    {
        $property_type = PropertyType::orderBy('name', 'asc')->get();
    
        return response()->json([
            'success' => true,
            'message' => 'Property Type fetched successfully',
            'data' => Property_typeResource::collection($property_type)
        ]);
    }
}
