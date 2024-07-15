<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RegistrasiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/login', [LoginController::class, 'testLogin']);
Route::post('/logout', [LogInController::class, 'logout'])->name('logout');

Route::post('/register', [RegistrasiController::class, 'register'])->name('register');
