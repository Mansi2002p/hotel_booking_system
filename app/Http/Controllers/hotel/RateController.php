<?php

namespace App\Http\Controllers\hotel;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class RateController extends Controller
{
    //
    public function showRate(){

        $payment = Review::get();
        return view('backend.hotel-owner.Reviews.list', compact('payment'));
    }

    public function getReviews(Request $request)
{
    if ($request->ajax()) {
        $query = Review::with(['user', 'hotel']);
        // $query = Review::with('hotels')->get();
        // dd($query);
        return DataTables::eloquent($query)
            ->addColumn('user', function ($review) {
                return $review->user->first_name . ' ' . $review->user->last_name ?? 'N/A';
            })
            ->addColumn('hotel', function ($review) {
                return $review->hotel ? $review->hotel->name : 'N/A';
            })
            
            ->addColumn('rating', function ($review) {
                return $review->rating . ' ⭐';
            })
            ->addColumn('comment', function ($review) {
                return $review->review ;
            })
            ->addColumn('created_at', function ($review) {
                return $review->created_at->format('d M Y');
            })
            // ->addColumn('action', function ($review) {
            //     return view('backend.reviews.action', compact('review'));
            // })
            ->rawColumns(['action'])
            ->toJson();
    }
}
}