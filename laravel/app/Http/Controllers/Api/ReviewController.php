<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Place;
use App\Models\Review;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($place_id)
    {
        if ( $this->authorize('viewAny', Place::class)) {
            $post = Place::find($place_id);
            return response()->json([
                'success' => true,
                'data' => $place->reviews ?? []
            ], 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $place_id)
    {
        if ( $this->authorize('create', Review::class)) {
            $request->validate([
                'review' => 'required|string',
            ]);
        
            $place = Place::find($place_id);

            if (!$place) {
                return response()->json([
                    'success' => false,
                    'message' => 'Place not found'
                ], 404);    
            }
            
            $user = auth()->user();
            $review = $place->reviews()->create([
                'author_id' => $user->id,
                'review' => $request->review,
            ]);
            
            return response()->json([
                'success' => true,
                'data' => $review
            ], 201);
        }
    }
    
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($place_id, $review_id)
    {
        $place = Place::find($place_id);
        $review = Review::find($review_id);
        \Log::debug($review);

        if (!$place) {
            return response()->json([
                'success' => false,
                'message' => 'Place not found'
            ], 404);    
        }

        if (!$review) {
            return response()->json([
                'success' => false,
                'message' => 'Review not found'
            ], 404);    
        }

        if ($this->authorize('delete', $review)) {
            $review->delete();
            return response()->json([
                'success' => true,
                'data' => $place
            ], 200);
        }
    }
}