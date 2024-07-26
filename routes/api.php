<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\GrafikController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileKodularController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\SendDataController;
use App\Http\Controllers\TrackingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['web'])->group(function () {
    Route::post('/login', [LoginController::class, 'actionlogin'])->name('actionlogin');
    Route::post('/logout', [LoginController::class, 'actionlogout'])->name('actionlogout');
    Route::put('/updateprofile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/updatepassword', [ProfileController::class, 'updatePassword'])->name('profile.passchange');
});

Route::get('/location', [TrackingController::class, 'index']);
Route::get('/data/location', [TrackingController::class, 'database']);
Route::get('/data/valid', [ParameterController::class, 'index'])->name('data.valid');

Route::post('/kodularlogin', [LoginController::class, 'kodularlogin']);

Route::post('/send', [SendDataController::class, 'send']);

Route::get('/waqms', [GrafikController::class, 'index']);
Route::post('/register', [RegistrasiController::class, 'register'])->name('register');


// BUAT HP
Route::get('/kodularProfile', [ProfileKodularController::class, 'index']);
Route::put('/kodularUpdateWeight', [ProfileKodularController::class, 'kodularUpdateWeight']);
