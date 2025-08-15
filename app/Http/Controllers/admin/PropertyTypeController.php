<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PropertyTypeController extends Controller
{
    //
    public function createOrEdit($id = null)
{
    $propertyType = $id ? PropertyType::findOrFail($id) : null;

    return view('backend.admin.property-type.createoredit', compact('propertyType'));
}

    public function createOrUpdate(Request $request, $id = null)
    {
        // Validate incoming request data
        $request->validate([
            'name' => 'required', 
        ]);
    
        // If ID exists, update existing record; otherwise, create a new one
        $propertyType = $id ? PropertyType::findOrFail($id) : new PropertyType();
        
        $propertyType->name = $request->name;
        $propertyType->save();
    
        // Determine message for success response
        $message = $id ? 'Property Type Updated Successfully' : 'Property Type Created Successfully';
    
        return redirect()->route('admin.property-list')->with('success', $message);
    }

    public function show()
    {
        $properties = PropertyType::all();
        return view('backend.admin.property-type.list', compact('properties'));
    }
    public function getPropertyTypes(Request $request)
    {
        if ($request->ajax()) {
            $query = PropertyType::query();

            // Apply filter if provided
            if ($request->has('name') && $request->name) {
                $query->where('name', 'LIKE', '%' . $request->name . '%');
            }

            return DataTables::eloquent($query)
                ->addColumn('action', function ($row) {
                    return view('backend.admin.property-type.action', compact('row'));
                })
                ->rawColumns(['action'])  // To render the action buttons (Edit, Delete)
                ->toJson();
        }
    }
   
  
public function destroy($id)
{
    $propertyType = PropertyType::findOrFail($id); // Find the property type by ID

    // Delete the property type
    $propertyType->delete();

    // Redirect back to the property list page with a success message
    return redirect()->route('admin.property-list')->with('success', 'Property Type Deleted Successfully');
}
}
