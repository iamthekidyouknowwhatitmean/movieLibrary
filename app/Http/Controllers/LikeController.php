<?php

namespace App\Http\Controllers;

use App\Models\Films;
use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index()
    {
        dd(User::find(Auth::id())->likedFilms);
    }
    public function store(Films $film)
    {
        $attributes = [
            'user_id' => Auth::id(),
            'films_id' => $film->id,
        ];
        Like::create($attributes);
        return redirect('/films');
    }
}
