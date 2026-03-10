<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Films;

class SearchController extends Controller
{
    public function index(Request $request){
        return response()->json([
            'result' => Films::query()->search($request->query('name'))->first()
        ]);
    }
}
