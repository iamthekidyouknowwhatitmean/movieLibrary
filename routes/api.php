<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FilmsController;
use App\Http\Controllers\FilmDetailsController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\WatchedController;
use App\Http\Controllers\WatchListController;
use App\Http\Controllers\RatingContoller;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NetworkController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Jobs\SendWelcomeEmail;

// Регистрация
Route::post('/register', [RegisterController::class,'store']);

// Авторизация
Route::post('/login',[AuthController::class,'login']);

Route::get('/search',[SearchController::class,'index']);

Route::middleware('auth:sanctum')->group(function(){
    // Выход из аккаунта
    Route::post('/logout',[AuthController::class,'logout']);

    // Настройки пользователя
    Route::post('/settings',[SettingsController::class,'update']);
    // Изменение пароля
    Route::post('/settings/auth',[SettingsController::class,'changePassword']);

    Route::get('/network/following',[NetworkController::class,'following']); // пользователи, за которыми мы следим
    Route::get('/network/followers',[NetworkController::class,'followers']); // пользователи, которые следят за нами, подписчики
    Route::post('/network/{following}',[NetworkController::class,'storeFollowing']); // cоздание пользователей, за которыми мы следим
    Route::delete('/network/following/{following}',[NetworkController::class,'destroyFollowing']); // удаление пользователей, за которыми мы следим
    Route::delete('/network/followers/{follower}',[NetworkController::class,'destroyFollower']); // удаление пользователей, которые следят за нам

    // Фильмы
    Route::get('/films', [FilmsController::class,'index']);

    // Детальная страница фильма
    Route::get('/film/{film}',[FilmDetailsController::class,'index']);

    // Фильмы, которые лайкнул пользователь
    Route::get('/likes', [LikeController::class,'index']);
    // Добавление в таблицу понравившихся фильмов (likes)
    Route::post('/likes/{film}',[LikeController::class,'store']);
    // Удаление из таблицы понравившегося фильма
    Route::delete('/likes/{film}',[LikeController::class,'destroy']);

    // Фильмы, для просмотра в будущем
    Route::get('/watchlist',[WatchListController::class,'index']);
    // Добавление в таблицу фильмов, для просмотра в будущем
    Route::post('/watchlist/{film}',[WatchListController::class,'store']);
    // Удаление из таблицы фильмов, для просмотра в будущем
    Route::delete('/watchlist/{film}',[WatchListController::class,'destroy']);

    // Фильмы, просмотренные пользователем
    Route::get('/watched',[WatchedController::class,'index']);
    // Добавление в таблицу фильмов, уже просмотренных пользователем
    Route::post('/watched/{film}',[WatchedController::class,'store']);
    // Удаление из таблицы фильмов, уже просмотренных пользователем
    Route::delete('/watched/{film}',[WatchedController::class,'destroy']);

    // Оценка фильма
    Route::post('/rating',[RatingContoller::class,'store']);
    // Удаление оценки фильма
    Route::delete('/rating',[RatingContoller::class,'destroy']);

    Route::get('/review/{reviewId}',[ReviewController::class,'show']);
    Route::post('/review',[ReviewController::class,'store']);
    Route::patch('/review',[ReviewController::class,'update']);
    Route::delete('/review',[ReviewController::class,'destroy']);

    Route::post('/comment',[CommentController::class,'store']);
    Route::patch('/comment/{comment}',[CommentController::class,'update']);
    Route::delete('/comment/{comment}',[CommentController::class,'destroy']);

    Route::get('/activity',[ActivityController::class,'index']);

    Route::prefix('/{user}')->group(function(){
        Route::get('',[UserController::class,'index']);
        Route::get('/watched',[UserController::class,'watched']);
        Route::get('/likes',[UserController::class,'likes']);
        Route::get('/watchlist',[UserController::class,'watchlist']);
        Route::get('/following',[UserController::class,'following']);
        Route::get('/followers',[UserController::class,'followers']);
        Route::get('/reviews',[UserController::class,'reviews']);
        Route::get('/activities',[UserController::class,'activities']);
    });

});
