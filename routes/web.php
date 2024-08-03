<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThingSpeakController;
use App\Http\Controllers\PersonalExposureController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\GrafikController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\TrackingController;



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
    Route::get('/dashboard', [PersonalExposureController::class, 'showPersonalExposure'])->name('dashboard');
    // Route::get('/waqmsmaps', [TrackingController::class, 'index']);
    Route::get('/waqmsmaps', function () {
        return view('mapsgps');
    });
    Route::get('/data-parameter', function () {
        return view('tabeldata');
    });
    Route::get('/data-location', function () {
        return view('tabeldatalocation');
    });
    Route::get('/history', function () {
        return view('History');
    });
});



Route::get('/', function () {
    return view('index1');
});

Route::get('/register', [RegistrasiController::class, 'index']);

Route::get('/login', [LoginController::class, 'login'])->name('login');


Route::get('/grafikwaqms', function () {
    return view('grafik');
});
Route::get('/grafikwaqms_1H', function () {
    return view('grafik_hourly');
});
Route::get('/grafikwaqms_1D', function () {
    return view('grafik_daily');
});
Route::get('/datamaps', function () {
    return view('tabeldata');
});


Route::get('/personal-exposure', [PersonalExposureController::class, 'showPersonalExposure'])->name('personal.exposure');

// BUAT HP
Route::get('/kodularmaps', function () {
    return view('mapskodular');
});
