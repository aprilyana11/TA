<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RegistrasiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonalExposureController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['web'])->group(function () {
    Route::post('/login', [LoginController::class, 'actionlogin'])->name('actionlogin');
    Route::post('/logout', [LoginController::class, 'actionlogout'])->name('actionlogout');
});


Route::post('/register', [RegistrasiController::class, 'register'])->name('register');
Route::post('/kodularlogin', [LoginController::class, 'kodularlogin']);

// routes/web.php atau routes/api.php

Route::post('/calculate-dose', 'App\Http\Controllers\DosisController@calculateDose')->name('calculate.dose');
