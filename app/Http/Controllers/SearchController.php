<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Films;
use App\Models\Review;
use App\Models\User;

class SearchController extends Controller
{
    public function index(Request $request){
        $value = $request->value;
        $type = $request->type;

        return response()->json([
            'films' => $type === null || $type === 'films'
            ? Films::search($value)->paginate(20)
            : [],

            'users' => $type === null || $type === 'users'
                ? User::search($value)->paginate(20)
                : [],

            'reviews' => $type === null || $type === 'reviews'
                ? Review::search($value)->paginate(20)
                : [],
        ]);
    }
}
