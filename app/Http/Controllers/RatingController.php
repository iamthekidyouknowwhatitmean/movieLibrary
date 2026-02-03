<?php

namespace App\Http\Controllers;

use App\Models\Films;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request, Films $film)
    {
        $attributes = [
            'user_id' => Auth::id(),
            'films_id' => $film->id,
            'rating' => $request->input('rating')
        ];

        Rating::create($attributes);
        return redirect('/films/' . $film->id);
    }
}
