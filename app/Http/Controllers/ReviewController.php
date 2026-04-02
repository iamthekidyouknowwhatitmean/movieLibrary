<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use App\Services\ReviewService;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json([
            'reviewText' => Review::find($id)->content,
            'comments' => Review::find($id)->comments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReviewRequest $request,ReviewService $reviewService)
    {
        $filmId = $request->input('film_id');
        $body = $request->input('body');
        $rating = $request->input('rating');

        $reviewService->store($filmId,$body,$rating);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReviewRequest $request,ReviewService $reviewService)
    {
        $filmId = $request->input('film_id');
        $body = $request->input('body');
        $rating = $request->input('rating');
        $like = false;
        if($request->boolean('likes')){
            $like = true;
        }
        $reviewService->update($filmId,$body,$rating,$like);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,ReviewService $reviewService)
    {
        $reviewId = $request->input('review_id');
        $reviewService->destroy($reviewId);
    }
}
