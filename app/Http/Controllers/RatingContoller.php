<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Films;
use App\Models\Rating;
use App\Http\Resources\FilmDetailsResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreRatingRequest;

class RatingContoller extends Controller
{
    public function store(StoreRatingRequest $request){
        $film = Films::find($request->input('film_id'));
        $rating =  Auth::user()->ratings()->where('films_id',$request->input('film_id'))->first();
        if(!$rating){
            Rating::create([
                'user_id' => Auth::id(),
                'films_id' => $request->input('film_id'),
                'rating' => $request->input('value')
            ]);
            $newAverage = round((($film->vote_average * $film->vote_count) + $request->input('value')) / ($film->vote_count + 1),3);
        }else{
            $rating->update([
                'rating' => $request->input('value')
            ]);
            $newAverage = round((($film->vote_average * $film->vote_count) - $film->vote_average + $request->input('value')) / ($film->vote_count + 1),3);
        }

        $film->update([
            'vote_average' => $newAverage
        ]);

        return response()->json([
            'message' => 'Ваша оценка принята'
        ]);
    }

    public function destroy(Request $request){
        $request->validate([
            'film_id' => 'required|integer'
        ]);

        $film = Films::find($request->input('film_id'));
        $rating =  Auth::user()->ratings()->where('films_id',$request->input('film_id'))->first();
        $newAverage = round((($film->vote_average * $film->vote_count) - $rating->rating) / ($film->vote_count - 1),3);
        $film->update([
            'vote_average' => $newAverage
        ]);

        $rating->delete();
        return response()->json([
            'message' => 'Ваша оценка успешно удалена'
        ]);
    }
}
