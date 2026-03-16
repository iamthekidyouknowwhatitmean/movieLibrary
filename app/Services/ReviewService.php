<?php

namespace App\Services;

use App\Models\Review;
use App\Models\Films;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class ReviewService
{
    public function store(int $filmId,?string $body,?int $rating)
    {
        $film = Films::find($filmId);
        $newAverage = round(($film->vote_average * $film->vote_count) + $rating / ($film->vote_count + 1),3);
        $film->update([
           'vote_average' => $newAverage,
           'vote_count' => $film->vote_count+1
        ]);

        Review::create([
            'body' => $body,
            'rating' => $rating,
            'film_id' => $filmId,
            'user_id' => Auth::id()
        ]);

        Activity::create([
            'user_id' => Auth::id(),
            'type' => 'create',
            'activitable_type' => Review::class,
            'activitable_id' => Auth::user()->reviews()->orderBy('reviews.id','desc')->first()->id
        ]);
    }

    public function update(int $filmId,?string $body,?int $rating,bool $like = false)
    {
        $review = Auth::user()->reviews()->where('film_id',$filmId)->first();
        $film = Films::find($filmId);
        $newAverage = round((($film->vote_average * $film->vote_count) - $review->rating + $rating) / ($film->vote_count),3);
        $film->update([
            'vote_average' => $newAverage,
        ]);

        if($like){
            Activity::create([
                'user_id' => Auth::id(),
                'type' => 'like',
                'activitable_type' => Review::class,
                'activitable_id' => Auth::user()->reviews()->orderBy('reviews.id','desc')->first()->id
            ]);
        }
        $review->update([
            'body' => $body,
            'likes' => $like===true ? $review->likes + 1 : $review->likes,
            'rating' => $rating
        ]);
    }

    public function destroy($reviewId)
    {
        $review = Review::find($reviewId);
        $film = Films::find($review->film_id);

        $newAverage = round((($film->vote_average * $film->vote_count) - $review->rating) / ($film->vote_count - 1),3);
        $film->update([
            'vote_average' => $newAverage,
            'vote_count' => $film->vote_count-1
        ]);
        $review->delete();
        if($review){
            return response()->json([
                'message' => 'Комментарий успешно удален!'
            ]);
        }
    }
}
