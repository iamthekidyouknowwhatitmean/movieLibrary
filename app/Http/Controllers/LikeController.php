<?php

namespace App\Http\Controllers;

use App\Http\Resources\FilmsResource;
use App\Models\Film;
use App\Models\Like;
use App\Models\User;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Filters\FilmsFilter;

class LikeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(FilmsFilter $filters)
    {
        $likedFilms = Auth::user()
                    ->likes()
                    ->filter($filters)
                    ->paginate(20);
        return FilmsResource::collection($likedFilms);
    }

    public function store(Film $film)
    {
        $likedFilm= Auth::user()->likes()->syncWithoutDetaching($film->id);
        return response()->json([
            'message' => 'success',
        ],200);
    }

    public function destroy(Film $film)
    {
        Auth::user()->likes()->detach($film->id);
        return response()->json([
            'message' => 'success',
        ],200);
    }
}
