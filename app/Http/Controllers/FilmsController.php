<?php

namespace App\Http\Controllers;

use App\Models\Films;
use App\Models\Genre;
use App\Services\TmdbService;
use Illuminate\Http\Request;

class FilmsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $tmdb;

    public function __construct(TmdbService $tmdb)
    {
        $this->tmdb = $tmdb;
        // dd($this->tmdb->getPopularMovies());
    }

    public function index()
    {
        $allFilms = Films::paginate(20);
        $genres = Genre::all();
        return view('films.all', [
            'allFilms' => $allFilms,
            'genres' => $genres
        ]);

        // $films = $this->tmdb->getPopularMovies();
        // dd($films);
        // return view('films.all', ['allFilms' => $films['results']]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('films.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => ['required']
        ]);

        // надо проверить нет ли такого уже в базе
        if (Films::find($attributes)) {
            dd('Такой фильм уже есть в базе!');
        } else {
            Films::create($attributes);
        }

        return redirect('/films');
    }

    /**
     * Display the specified resource.
     */
    public function show(Films $film)
    {
        return view('films.show', ['film' => $film]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Films $film)
    {
        return view('films.edit', ['film' => $film]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Films $film)
    {
        $attributes = $request->validate([
            'name' => ['required']
        ]);
        $film->update($attributes);
        return redirect("/films/" . $film->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Films $film)
    {
        $film->delete();
        return redirect('/films');
    }

    public function search(Request $request)
    {
        $query = $request->input('search');
        $films = $query ? Films::search($query)->get() : collect();

        return view('films.search', [
            'query' => $query,
            'films' => $films
        ]);
    }
}
