<?php

namespace App\Http\Controllers;

use App\Models\dosis;
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
        $yesterday1 = Carbon::now()->subHour()->startOfHour();
        $yesterday2 = Carbon::now()->subHour()->endOfHour();
        $user = User::where('username', $request->input('username'))->first();
        $data = WAQMS_Valid::latest('created_at')->first();

        // Ambil data dari database
        $weight = $user->weight; // Berat badan dari user

        $intensity = 0.83; // Laju inhalasi default untuk orang dewasa 
        $activityFactor = 1.0; // Faktor aktivitas 
        $residenceFactor = 1.0; // Faktor residensi 

        // Gunakan $intensity, $activityFactor, dan $residenceFactor dalam perhitungan dosis

        // Jika gagal mendapatkan nilai dari Thingspeak, gunakan nilai default
        $dose = (15 * $intensity * $residenceFactor * $activityFactor) / 70;

        // Hitung dosis paparan
        $pm25Dose = WAQMS_Valid::whereBetween('created_at', [$yesterday1, $yesterday2])->pluck('pm25');;

        // Cek apakah jumlah data setidaknya 480
        if ($pm25Dose->count() >= 45) { //75% dari 60 data ( 1 jam) 
            // Hitung rata-rata dari data 'pm25'
            $pm25Average = $pm25Dose->average();
            $doseCalculate = ($pm25Average * 0.83 * 1 * 1) / $weight;
            $doseCalculate = number_format($doseCalculate, 2);
        } else {
            // Jika kurang dari 480 data, set $pm25Average menjadi null
            $pm25Average = null;
            $dose = null;
        }


        $exposure_level = 'Tidak Ada';

        $starofday = Carbon::now()->startOfDay();
        $sekarang = Carbon::now();
        $dosis = dosis::whereBetween('created_at', [$starofday, $sekarang])->sum('dosis');

        //KUOTA 
        $pi3 = 4.29 * 0.75;
        $pi2 = 4.29 * 0.5;
        $pi1 = 4.29 * 0.25;
        $pi0 = 0;

        $kuota = 4.29 - $dosis;
        //KUOTA
        // Tentukan level paparan berdasarkan exposure_value
        if ($dosis === null) {
            $exposure_level = 'Tidak Ada';
        } elseif ($kuota >= $pi3) {
            $exposure_level = 'Sangat Aman';
        } elseif ($kuota >= $pi2 && $kuota < $pi3) {
            $exposure_level = 'Cukup Aman';
        } elseif ($kuota >= $pi1 && $kuota < $pi2) {
            $exposure_level = 'Aman';
        } elseif ($kuota >= 0 && $kuota < $pi1) {
            $exposure_level = 'Hati - Hati';
        } else {
            $exposure_level = 'Berbahaya';
        }

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
            'exposureValue' => $doseCalculate,
            'recommendationTime' => $recommendationTime
        ]);
    }
}
