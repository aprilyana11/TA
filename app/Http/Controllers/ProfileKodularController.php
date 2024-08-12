<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\WAQMS_Valid;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ProfileKodularController extends Controller
{
    // Metode-metode controller Anda

    public function index(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required'
        ]);

        $user = User::where('username', $credentials['username'])->first();

        return response()->json([
            "username" => $user['username'],
            "weight" => $user['weight'],
            "gender" => $user['gender']
        ]);
    }
    public function kodularUpdateWeight(Request $request)
    {
        $user = User::where('username', $request->input('username'))->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        // Update the user's weight
        $user->weight = $request->input('weight');
        // /** @var \App\Models\User $user **/
        $user->save();
        return response()->json(['message' => 'Weight updated successfully.']);
    }

    public function kodularUpdatePassword(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
            'newPassword' => 'required'
        ]);

        $user = User::where('username', $request->input('username'))->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Update the user's weight
            $user->password = Hash::make($request->newPassword);
            /** @var \App\Models\User $user **/
            $user->save();


            return response()->json(['message' => 'Password updated successfully.'], 200);
        } else {
            return response()->json(['message' => 'Wrong Password / Username'], 201);
        }
    }
    public function PersonalExposure(Request $request)
    {
        $yesterday1 = Carbon::now()->subDay()->startOfDay();
        $yesterday2 = Carbon::now()->subDay()->endOfDay();
        $user = User::where('username', $request->input('username'))->first();
        $data = WAQMS_Valid::latest('created_at')->first();

        // Ambil data dari database
        $weight = $user->weight; // Berat badan dari user

        $intensity = 0; // nilai inhalasi, disesuaikan dengan data (cari relasi antara bb dengan IR)
        $activityFactor = 1; // nilai faktor aktivitas
        $residenceFactor = 1; // nilai faktor residensi
        // Hitung dosis paparan
        $pm25Dose = WAQMS_Valid::whereBetween('created_at', [$yesterday1, $yesterday2])->pluck('pm25');;

        // Cek apakah jumlah data setidaknya 480
        if ($pm25Dose->count() >= 480) {
            // Hitung rata-rata dari data 'pm25'
            $pm25Average = $pm25Dose->average();
            $dose    = $pm25Average * $intensity * $activityFactor * $residenceFactor / $weight;
        } else {
            // Jika kurang dari 480 data, set $pm25Average menjadi null
            $pm25Average = null;
            $dose = null;
        }


        $exposure_level = 'Tidak Ada';

        // Tentukan level paparan berdasarkan exposure_value
        if ($dose === null) {
            $exposure_level = 'Tidak Ada';
        } elseif ($dose < 0.01) {
            $exposure_level = 'Rendah';
        } elseif ($dose >= 0.01 && $dose < 0.05) {
            $exposure_level = 'Sedang';
        } elseif ($dose >= 0.05 && $dose < 0.10) {
            $exposure_level = 'Tinggi';
        } elseif ($dose >= 0.10) {
            $exposure_level = 'Sangat Tinggi';
        }
        // Data ditampilkan di view
        $exposureValue = $dose ? $dose : null;

        $recommendationTime = now()->format('H:i, M d'); // Waktu saat ini sebagai contoh

        return response()->json([
            'created_at' => $data['created_at'],
            'pm25' => $data['pm25'],
            'pm10' => $data['pm10'],
            'temperature' => $data['temperature'],
            'humidity' => $data['humidity'],
            'pressure' => $data['pressure'],
            'tvoc' => $data['tvoc'],
            'eco2' => $data['eco2'],

            'exposure_level' => $exposure_level,
            'exposureValue' => $exposureValue,
            'recommendationTime' => $recommendationTime
        ]);
    }
}
