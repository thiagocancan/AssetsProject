<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewController extends Controller
{
    /**
     * Display all reviews of an asset.
     */
    public function index()
    {
        $reviews = Review::with('user.profile')->get();

        if ($reviews->isEmpty()) {
            return response()->json([
                'message' => 'No reviews found for this asset or the asset does not exist.'
            ], 404);
        }

        return response()->json($reviews, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, int $assetId)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        if (Review::where('user_id', $request->user()->id)->where('asset_id', $assetId)->exists()) {
            return response()->json([
                'message' => 'You already rated this asset.'
            ], 422);
        }

        $review = Review::create([
            'user_id' => $request->user()->id,
            'asset_id' => $assetId,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return response()->json([
            'message' => 'Review created successfully.',
            'review' => $review
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json([
                'message' => 'Review not found.'
            ], 404);
        }

        return response()->json($review, 200);
    }

    /**
     * Update review.
     */
    public function update(Request $request, $id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json([
                'message' => 'Review not found.'
            ], 404);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review->update($validated);

        return response()->json([
            'message' => 'Review updated successfully.',
            'review' => $review
        ], 200);
    }

    /**
     * Remove review from storage.
     */
    public function destroy($id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json([
                'message' => 'Review not found.'
            ], 404);
        }

        if ($review->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $review->delete();

        return response()->json([
            'message' => 'Review deleted successfully.'
        ], 200);
    }
}
