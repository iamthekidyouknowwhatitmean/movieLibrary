<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Films;
use App\Http\Resources\FilmDetailsResource;

class FilmDetailsController extends Controller
{
    public function index(Films $film)
    {
        return new FilmDetailsResource($film);
    }
}
