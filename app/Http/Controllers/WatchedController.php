<?php

namespace App\Http\Controllers;

use App\Http\Resources\FilmsResource;
use App\Models\User;
use App\Models\Films;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Filters\FilmsFilter;

class WatchedController extends Controller
{
    public function index(FilmsFilter $filters)
    {
        $watchedFilms = Auth::user()
                    ->watched()
                    ->filter($filters)
                    ->paginate(20);

        return FilmsResource::collection($watchedFilms);
    }

    public function store(Films $film)
    {
        Auth::user()->watched()->attach($film->id);
        return response()->json([
            'message' => 'success',
        ],200);
    }

    public function destroy(Films $film)
    {
        Auth::user()->watched()->detach($film->id);
        return response()->json([
            'message' => 'success',
        ],200);
    }
}
