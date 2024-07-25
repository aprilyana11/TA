<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\GrafikController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileKodularController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\SendDataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['web'])->group(function () {
    Route::post('/login', [LoginController::class, 'actionlogin'])->name('actionlogin');
    Route::post('/logout', [LoginController::class, 'actionlogout'])->name('actionlogout');
});
Route::post('/kodularlogin', [LoginController::class, 'kodularlogin']);

Route::post('/send', [SendDataController::class, 'send']);

Route::get('/waqms', [GrafikController::class, 'index']);
Route::post('/register', [RegistrasiController::class, 'register'])->name('register');

Route::get('/kodularProfile', [ProfileKodularController::class, 'index']);
