<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Place;


class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(int $placeId)
    {
        if ($this->authorize('viewAny', Post::class)) {
            $place = Place::find($placeId);

            if (!$place) {
                return redirect()->route('places.index')->with('error', 'Lugar no encontrado.');
            }

            $reviews = $place->reviews;

            return view("places.show", ["place" => $place, "reviews" => $reviews]);
        }
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, int $place)
    {
        if ($this->authorize('create', Review::class)) {
            $validatedData = $request->validate([
                'review' => 'required|max:120',
            ]);

            $review = $request->get('review');

            $createReview = Review::create([
                'place_id'  => $place,
                'review'    => $review,
                'author_id' => auth()->user()->id,
            ]);

            return redirect()->route('places.show', ['place' => $place])->with('success', 'Reseña creada con éxito');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($placeId, $reviewId)
    {
        if ($this->authorize('create', Review::class)) {

            $review = Review::find($reviewId);
        
            if ($review) {
                $review->delete();
                return redirect()->route('places.show', ['place' => $placeId])->with('success', 'Reseña eliminada correctamente');
            } else {
                return redirect()->route('places.index')->with('error', 'Reseña no encontrada.');
            }
        }
    }
}