<?php

namespace App\Http\Controllers;

use App\Http\Resources\FilmsResource;
use App\Models\Films;
use App\Models\Like;
use App\Models\User;
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
                    ->likedFilms()
                    ->filter($filters)
                    ->paginate(20);

        return FilmsResource::collection($likedFilms);
    }

    public function store(Films $film)
    {
        $result = Auth::user()->likedFilms()->attach($film->id);

        return response()->json([
            'message' => 'success',
        ],200);
    }

    public function destroy(Films $film)
    {
        Auth::user()->likedFilms()->detach($film->id);
        return response()->json([
            'message' => 'success',
        ],200);
    }
}
