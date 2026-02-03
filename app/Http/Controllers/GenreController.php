<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        $genre = Genre::where('name', $request->input('genre'))->first();
        $films = $genre->films()->paginate(15)->withQueryString();
        return view('genres.all', [
            'films' => $films
        ]);
        // dd($request->input('genre'));
    }
}
