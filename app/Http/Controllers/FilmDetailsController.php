<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film;
use App\Http\Resources\FilmDetailsResource;

class FilmDetailsController extends Controller
{
    public function index(Film $film)
    {
        // $film->load(['reviews:id,film_id,content']);

        return new FilmDetailsResource($film);
    }
}
