<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
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
