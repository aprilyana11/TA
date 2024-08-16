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
        if ($user->age <= 1) {
            $intensity = 4.5; // Laju inhalasi untuk bayi (0-1 tahun)
            $activityFactor = 1.2; // Faktor aktivitas untuk bayi (0-1 tahun)
            $residenceFactor = 0.9; // Faktor residensi untuk bayi (0-1 tahun)
        } elseif ($user->age <= 5) {
            $intensity = 9.0; // Laju inhalasi untuk anak-anak (1-5 tahun)
            $activityFactor = 1.3; // Faktor aktivitas untuk anak-anak (1-5 tahun)
            $residenceFactor = 0.85; // Faktor residensi untuk anak-anak (1-5 tahun)
        } elseif ($user->age <= 12) {
            $intensity = 13.5; // Laju inhalasi untuk anak-anak (6-12 tahun)
            $activityFactor = 1.1; // Faktor aktivitas untuk anak-anak (6-12 tahun)
            $residenceFactor = 0.75; // Faktor residensi untuk anak-anak (6-12 tahun)
        } elseif ($user->age >= 65) {
            $intensity = 13.0; // Laju inhalasi untuk lansia (65+ tahun)
            $activityFactor = 0.9; // Faktor aktivitas untuk lansia (65+ tahun)
            $residenceFactor = 0.85; // Faktor residensi untuk lansia (65+ tahun)
        } else {
            $intensity = 18.0; // Laju inhalasi default untuk orang dewasa (18-64 tahun)
            $activityFactor = 1.0; // Faktor aktivitas default untuk orang dewasa (18-64 tahun)
            $residenceFactor = 0.7; // Faktor residensi default untuk orang dewasa (18-64 tahun)
        }

        // Hitung dosis paparan
        $pm25Dose = WAQMS_Valid::whereBetween('created_at', [$yesterday1, $yesterday2])->pluck('pm25');;

        // Cek apakah jumlah data setidaknya 480
        if ($pm25Dose->count() >= 1080) { //1 hari yang lalu, 24 jam * 60 data / 1 jamnya 75% 
            // Hitung rata-rata dari data 'pm25'
            $pm25Average = $pm25Dose->average();
            $dose = ($pm25Average * $intensity * $activityFactor * $residenceFactor) / $weight;
            $RQ = $dose / 15; //15 RFD acuan 15 ug/m3 WHO 2021 per hari
        } else {
            // Jika kurang dari 480 data, set $pm25Average menjadi null
            $pm25Average = null;
            $dose = null;
            $RQ = null;
        }


        $exposure_level = 'Tidak Ada';

        // Tentukan level paparan berdasarkan exposure_value
        if ($RQ === null) {
            $exposure_level = 'Tidak Ada';
        } elseif ($RQ < 0) {
            $exposure_level = 'Rendah';
        } elseif ($RQ >= 0 && $RQ < 1) {
            $exposure_level = 'Sedang';
        } elseif ($RQ >= 1) {
            $exposure_level = 'Tinggi';
        }
        // Data ditampilkan di view
        $exposureValue = $RQ ? number_format($RQ, 2) : null;

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
