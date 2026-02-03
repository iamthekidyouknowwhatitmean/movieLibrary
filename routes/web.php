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
    return 'hello';
});

Route::get('/likes/films', [LikeController::class, 'index']); // Выводит все фильмы, лайкнутые пользователем
Route::post('/like/{film}', [LikeController::class, 'store']); // POST запрос, который сохраняет лайк на конкретный фильм

Route::post('/watchlist/{film}', [WatchListController::class, 'store']);
Route::get('/watchlist', [WatchListController::class, 'index']);

Route::get('/settings', [UserController::class, 'index'])->middleware('auth');
Route::patch('/settings/{user}', [UserController::class, 'update'])->middleware('auth');

//Route::get('/likes',[])
Route::get('/login', [SessionController::class, 'create'])->middleware('guest');
Route::post('/login', [SessionController::class, 'store'])->middleware('guest');
Route::post('/logout', [SessionController::class, 'destroy'])->middleware('auth');

Route::get('/films/genre', GenreController::class);
Route::get('/films/add', [FilmsController::class, 'create']); // перенос на форму добавление фильма, только админ
Route::delete('/films/{film}', [FilmsController::class, 'destroy']); // удаление одного фильма
Route::get('/films/{film}/edit', [FilmsController::class, 'edit']); // перенос на форму редактирования свойств фильма
Route::patch('/films/{film}', [FilmsController::class, 'update']); // обновление свойств фильма
Route::post('/films/search', [FilmsController::class, 'search']);
Route::get('/films/{film}', [FilmsController::class, 'show']); // детальный просмотр свойств одного фильма
Route::post('/films/{film}/favorite', [FavoritesController::class, 'store']); // добавление в избранное
Route::post('/films/{film}/rate', [RatingController::class, 'store']); // оценка фильма
Route::post('/films/{film}/review', [ReviewController::class, 'store']); // отзыв фильму

Route::get('/films', [FilmsController::class, 'index']); // показывает все фильмы
Route::post('/films', [FilmsController::class, 'store']); // запрос из формы добавления, сохранение в базу, только админ
