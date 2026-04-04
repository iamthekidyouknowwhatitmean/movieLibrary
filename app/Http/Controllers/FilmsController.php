<?php

namespace App\Http\Controllers;

use App\Http\Filters\FilmsFilter;
use App\Models\Film;
use App\Models\Genre;
use App\Services\TmdbService;
use Illuminate\Http\Request;

class FilmsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FilmsFilter $filters)
    {
        $films = Film::filter($filters)->paginate(20);

        return response()->json($films);
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
        if (Film::find($attributes)) {
            dd('Такой фильм уже есть в базе!');
        } else {
            Film::create($attributes);
        }

        return redirect('/films');
    }

    /**
     * Display the specified resource.
     */
    public function show(Film $film)
    {
        return view('films.show', ['film' => $film]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Film $film)
    {
        return view('films.edit', ['film' => $film]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Film $film)
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
    public function destroy(Film $film)
    {
        $film->delete();
        return redirect('/films');
    }

    public function search(Request $request)
    {
        $query = $request->input('search');
        $films = $query ? Film::search($query)->get() : collect();

        return view('films.search', [
            'query' => $query,
            'films' => $films
        ]);
    }
}
