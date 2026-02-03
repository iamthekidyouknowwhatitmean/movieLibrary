<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\SettingsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Регистрация
Route::post('/register', [RegisterController::class,'store']);
// Авторизация
Route::post('/login',[AuthController::class,'login']);
// Выход из аккаунта
Route::post('/logout',[AuthController::class,'logout'])->middleware('auth:sanctum');

// Настройки пользователя
Route::post('/settings',[SettingsController::class,'update'])->middleware('auth:sanctum');
// Изменение пароля
Route::post('/settings/auth',[SettingsController::class,'changePassword'])->middleware('auth:sanctum');

//
