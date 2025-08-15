<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Amenities;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AmentitiesController extends Controller
{
     //
    public function createOrEdit($id = null)
{
    $amenities = $id ? Amenities::findOrFail($id) : null;

    return view('backend.admin.amenities.craeteoredit', compact('amenities'));
}
    public function createOrUpdate(Request $request, $id = null)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $amenities = $id ? Amenities::findOrFail($id) : new Amenities();
        $amenities->name = $request->name;
        $amenities->save();

        return redirect()->route('admin.amenities-list')
            ->with('success', $id ? 'Amenities Updated Successfully' : 'Amenities Created Successfully');
    }

    public function show()
    {
        $amenities = Amenities::all();
        return view('backend.admin.amenities.list', compact('amenities'));
    }

    public function getAmenitiesTypes(Request $request)
    {
        if ($request->ajax()) {
            $query = Amenities::query();

            if ($request->has('name') && $request->name) {
                $query->where('name', 'LIKE', '%' . $request->name . '%');
            }

            return DataTables::eloquent($query)
                ->addColumn('action', function ($row) {
                    return view('backend.admin.amenities.action', compact('row'));
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return response()->json(['error' => 'Not an AJAX request'], 400);
    }

    public function edit($id)
    {
        $amenities = Amenities::findOrFail($id);
        return view('backend.admin.amenities.edit', compact('amenities'));
    }

    public function destroy($id)
    {
        $amenities = Amenities::findOrFail($id);
        $amenities->delete();

        return redirect()->route('admin.amenities-list')
            ->with('success', 'Amenities Deleted Successfully');
    }
}
