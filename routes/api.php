<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\GrafikController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileKodularController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\SendDataController;
use App\Http\Controllers\StatistikController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\DosisController;

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
Route::get('/data/kodular', [ParameterController::class, 'kodular']);


Route::post('/send', [SendDataController::class, 'send']);
Route::get('/History/{type}', [DataController::class, 'History']);
Route::get('/Statistik/{parameter}', [StatistikController::class, 'index']);

Route::get('/waqms', [GrafikController::class, 'index']);
Route::get('/waqms/1H', [GrafikController::class, 'per_jam']);
Route::get('/waqms/1D', [GrafikController::class, 'per_day']);
Route::post('/register', [RegistrasiController::class, 'register'])->name('register');


// BUAT HP
Route::get('/kodularProfile', [ProfileKodularController::class, 'index']);
Route::get('/kodularUpdateWeight', [ProfileKodularController::class, 'kodularUpdateWeight']);
Route::get('/kodularUpdatePassword', [ProfileKodularController::class, 'kodularUpdatePassword']);
Route::post('/kodularlogin', [LoginController::class, 'kodularlogin']);
Route::get('/kodularExposure', [ProfileKodularController::class, 'PersonalExposure']);

Route::post('/dosis', [DosisController::class, 'index']);
Route::get('/dosis', [DosisController::class, 'read']);
