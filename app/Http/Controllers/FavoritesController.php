<?php

namespace App\Http\Controllers;

use App\Models\Films;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function store(Films $film)
    {
        Auth::user()->films()->attach($film);
        return redirect("/films/" . $film->id);
    }
}
