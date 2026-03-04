<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Films;
use App\Http\Resources\FilmDetailsResource;

class FilmDetailsController extends Controller
{
    public function index(Films $film)
    {
        // $film->load(['reviews' => function ($q) {
        //     $q->select('id', 'film_id', 'content');
        // }]);

        $film->load(['reviews:id,film_id,content']);

        return new FilmDetailsResource($film);
    }
}
