<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FilmsController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\WatchedController;
use App\Http\Controllers\WatchListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Регистрация
Route::post('/register', [RegisterController::class,'store']);
// Авторизация
Route::post('/login',[AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function(){
    // Выход из аккаунта
    Route::post('/logout',[AuthController::class,'logout']);

    // Настройки пользователя
    Route::post('/settings',[SettingsController::class,'update']);
    // Изменение пароля
    Route::post('/settings/auth',[SettingsController::class,'changePassword']);

    // Фильмы
    Route::get('/films', [FilmsController::class,'index']);

    // Фильмы, которые лайкнул пользователь
    Route::get('/likes', [LikeController::class,'index']);
    // Добавление в таблицу понравившихся фильмов (likes)
    Route::post('/likes/{film}',[LikeController::class,'store']);

    // Фильмы, для просмотра в будущем
    Route::get('/watchlist',[WatchListController::class,'index']);
    // Добавление в таблицу фильмов, для просмотра в будущем
    Route::post('/watchlist/{film}',[WatchListController::class,'store']);

    // Фильмы, просмотренные пользователем
    Route::get('/watched',[WatchedController::class,'index']);
    // Добавление в таблицу фильмов, уже просмотренных пользователем
    Route::post('/watched/{film}',[WatchedController::class,'store']);
});
