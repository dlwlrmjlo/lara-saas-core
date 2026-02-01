<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Src\Identity\Infrastructure\Http\Controllers\RegisterUserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public Routes
Route::post('/register', RegisterUserController::class);
