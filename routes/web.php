<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThingSpeakController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PersonalExposureController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/dashboard', function () {
        return view('index3');
    })->name('dashboard');
});



Route::get('/', function () {
    return view('index1');
});

Route::get('/register', [RegistrasiController::class, 'index']);

Route::get('/login', [LoginController::class, 'login'])->name('login');

Route::get('/grafikwaqms', function () {
    return view('grafik');
});
Route::get('/waqmsmaps', function () {
    return view('mapsgps');
});
Route::get('/datamaps', function () {
    return view('tabeldata');
});

Route::get('/thingspeak', [ThingSpeakController::class, 'index']);



// routes/web.php
Route::post('/profile/upload', [ProfileController::class, 'uploadPicture'])->name('profile.upload');
Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
Route::post('/profile/password/update', [ProfileController::class, 'updatePassword'])->name('password.update');
