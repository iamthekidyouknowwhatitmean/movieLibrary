<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Films;
use Illuminate\Support\Facades\Auth;

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
        Review::create([
            'content' => $request->input('content'),
            'film_id' => $request->input('film_id'),
            'user_id' => Auth::id()
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $filmId)
    {
        $review = Auth::user()->reviews()->where('film_id',$filmId)->first();
        $review->update([
            'content' => $request->input('content')
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
