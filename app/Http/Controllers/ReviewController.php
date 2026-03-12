<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Films;
use Illuminate\Support\Facades\Auth;
use App\Models\Activity;

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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'body' => 'nullable|string|required_without:rating',
            'rating' => 'nullable|integer|min:1|max:5|required_without:body',
        ]);

        $film = Films::find($request->input('film_id'));
        $newAverage = round((($film->vote_average * $film->vote_count) + $request->input('rating')) / ($film->vote_count + 1),3);
        $film->update([
           'vote_average' => $newAverage
        ]);

        Review::create([
            'body' => $request->input('body'),
            'rating' => $request->input('rating'),
            'film_id' => $request->input('film_id'),
            'user_id' => Auth::id()
        ]);

        Activity::create([
            'user_id' => Auth::id(),
            'type' => 'create',
            'activitable_type' => Review::class,
            'activitable_id' => Auth::user()->reviews()->orderBy('reviews.id','desc')->first()->id
        ]);
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $filmId)
    {
        $review = Auth::user()->reviews()->where('film_id',$filmId)->first();

        if($request->has('likes')){
            Activity::create([
                'user_id' => Auth::id(),
                'type' => 'like',
                'activitable_type' => Review::class,
                'activitable_id' => Auth::user()->reviews()->orderBy('reviews.id','desc')->first()->id
            ]);
        }
        $review->update([
            'body' => $request->input('body'),
            'likes' => $request->has('likes') ? $review->likes + 1 : $review->likes
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $filmId)
    {
        $result = Auth::user()->reviews()->where('film_id',$filmId)->first()->delete();
        if($result){
            return response()->json([
                'message' => 'Комментарий успешно удален!'
            ]);
        }
    }
}
