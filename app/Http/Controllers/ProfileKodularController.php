<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\WAQMS_Valid;
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
            $user->password = Hash::make($request->new_password);
            /** @var \App\Models\User $user **/
            $user->save();


            return response()->json(['message' => 'Password updated successfully.'], 200);
        } else {
            return response()->json(['message' => 'Wrong Password / Username'], 201);
        }
    }
    public function PersonalExposure(Request $request)
    {
        $user = User::where('username', $request->input('username'))->first();
        $data = WAQMS_Valid::latest('created_at')->first();

        // Ambil data dari database
        $weight = $user->weight; // Berat badan dari user

        $intensity = 20; // nilai inhalasi, disesuaikan dengan data (cari relasi antara bb dengan IR)
        $activityFactor = 1; // nilai faktor aktivitas
        $residenceFactor = 1; // nilai faktor residensi
        $pm25 = $data['pm25'];
        // Hitung dosis paparan
        $dose = $pm25 * $intensity * $activityFactor * $residenceFactor / $weight;

        // Data ditampilkan di view
        $exposure_level = 'Tidak sehat'; // harus diubah sesuai dengan logika
        $exposureValue = round($dose); // Pembulatan dosis
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
