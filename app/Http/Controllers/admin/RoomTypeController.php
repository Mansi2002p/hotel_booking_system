<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RoomTypeController extends Controller
{

    public function createOrEdit($id = null)
    {
        $roomType = $id ? RoomType::findOrFail($id) : null;
    
        return view('backend.admin.room-type.createoredit', compact('roomType'));
    }
    public function createOrUpdate(Request $request, $id = null)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // If an ID is provided, update the existing record; otherwise, create a new one
        $roomType = RoomType::find($id) ?? new RoomType();
        $roomType->name = $request->name;
        $roomType->save();

        // Determine the success message
        $message = $id ? 'Room Type Updated Successfully' : 'Room Type Created Successfully';

        return redirect()->route('admin.room-list')->with('success', $message);
    }

    public function show()
    {
        $rooms = RoomType::all();
        return view('backend.admin.room-type.list', compact('rooms'));
    }

    public function getRoomTypes(Request $request)
    {
        if ($request->ajax()) {
            $query = RoomType::query();

            if ($request->has('name') && $request->name) {
                $query->where('name', 'LIKE', '%' . $request->name . '%');
            }

            return DataTables::eloquent($query)
                ->addColumn('action', function ($row) {
                    return view('backend.admin.room-type.action', compact('row'));
                })
                ->rawColumns(['action'])
                ->toJson();
        }
    }

    public function edit($id)
    {
        $roomType = RoomType::findOrFail($id);
        return view('backend.admin.room-type.createoredit', compact('roomType'));
    }

    public function destroy($id)
    {
        $roomType = RoomType::findOrFail($id);
        $roomType->delete();

        return redirect()->route('admin.room-list')->with('success', 'Room Type Deleted Successfully');
    }
}
