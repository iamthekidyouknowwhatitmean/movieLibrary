<?php

use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\FilmsController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WatchListController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});
