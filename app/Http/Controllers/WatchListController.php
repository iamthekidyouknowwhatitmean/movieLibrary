<?php

namespace App\Http\Controllers;

use App\Http\Resources\FilmsResource;
use App\Models\Films;
use App\Models\User;
use App\Models\WatchList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WatchListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return FilmsResource::collection(User::find(Auth::id())->watchlist);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Films $film)
    {
        Auth::user()->watchlist()->attach($film->id);
        return response()->json([
            'message' => 'success',
        ],200);
    }

    public function destroy(Films $film)
    {
        Auth::user()->watchlist()->detach($film->id);
        return response()->json([
            'message' => 'success',
        ],200);
    }
}
