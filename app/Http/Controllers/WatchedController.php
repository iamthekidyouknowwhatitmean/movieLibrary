<?php

namespace App\Http\Controllers;

use App\Http\Resources\FilmsResource;
use App\Models\User;
use App\Models\Film;
use App\Models\Activity;
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

    public function store(Film $film)
    {
        $temp = Auth::user()->watched();
        $temp->attach($film->id);

        Activity::create([
            'user_id' => Auth::id(),
            'type' => 'watched',
            'activitable_type' => Film::class,
            'activitable_id' => $temp->orderBy('watched.id','desc')->first()->id
        ]);
        return response()->json([
            'message' => 'success',
        ],200);
    }

    public function destroy(Film $film)
    {
        Auth::user()->watched()->detach($film->id);
        return response()->json([
            'message' => 'success',
        ],200);
    }
}
