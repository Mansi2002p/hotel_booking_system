<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;

class ReviewApiController extends Controller
{
    //
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
        ]);

        $review = Review::create([
            'user_id' => auth()->id(),
            'hotel_id' => $request->hotel_id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review submitted successfully.',
            'data' => $review
        ], 201);
    }

    // Get Reviews for a Hotel
    public function hotelReviews($hotel_id)
    {
        $reviews = Review::where('hotel_id', $hotel_id)
            ->with('user:id,first_name')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $reviews
        ]);
    }
}
