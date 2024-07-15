<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RegistrasiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['web'])->group(function () {
    Route::post('/login', [LoginController::class, 'actionlogin'])->name('actionlogin');
    Route::post('/logout', [LoginController::class, 'actionlogout'])->name('actionlogout');
});


Route::post('/register', [RegistrasiController::class, 'register'])->name('register');
