<?php

namespace App\Http\Controllers;

use App\Models\dosis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PersonalExposure;
use App\Models\User;
use App\Models\WAQMS_Valid;
use Carbon\Carbon;


class PersonalExposureController extends Controller
{
    public function showPersonalExposure()
    {
        $yesterday1 = Carbon::now()->subHour()->startOfHour();
        $yesterday2 = Carbon::now()->subHour()->endOfHour();
        $data = WAQMS_Valid::latest('created_at')->first();

        // Ambil data dari database
        $user = Auth::user();
        $weight = $user->weight; // Berat badan dari user

        $intensity = 0.83; // Laju inhalasi default untuk orang dewasa 
        $activityFactor = 1.0; // Faktor aktivitas 
        $residenceFactor = 1.0; // Faktor residensi 

        // Gunakan $intensity, $activityFactor, dan $residenceFactor dalam perhitungan dosis

        // Jika gagal mendapatkan nilai dari Thingspeak, gunakan nilai default
        $dose = (15 * $intensity * $residenceFactor * $activityFactor) / 70;

        // Inisialisasi $doseCalculate untuk menangani kasus di mana variabel ini mungkin tidak diatur
        $doseCalculate = null;

        if ($data === null) {
            $pm25 = null;
            $data = [
                'created_at' => '-',
                'pm25' => '-',
                'pm10' => '-',
                'temperature' => '-',
                'humidity' => '-',
                'pressure' => '-',
                'tvoc' => '-',
                'eco2' => '-'
            ];
            $exposure_level = '-'; // harus diubah sesuai dengan logika
            $recommendationTime = now()->format('H:i, M d'); // Waktu saat ini sebagai contoh

        } else {
            $pm25Dose = WAQMS_Valid::whereBetween('created_at', [$yesterday1, $yesterday2])->pluck('pm25');

            // Cek apakah jumlah data setidaknya 45
            if ($pm25Dose->count() >= 270) { //1jam * 60 data / 1 jamnya 75% 
                // Hitung rata-rata dari data 'pm25'
                $pm25Average = $pm25Dose->average();
                $doseCalculate = ($pm25Average * 0.83 * 1 * 1) / $weight;
                $doseCalculate = number_format($doseCalculate, 2);
            } else {
                $pm25Average = null;
            }

            $exposure_level = '-';
            $starofday = Carbon::now()->startOfDay();
            $sekarang = Carbon::now();
            $dosis = dosis::whereBetween('created_at', [$starofday, $sekarang])->sum('dosis');

            //dosis 



            //KUOTA
            // Tentukan level paparan berdasarkan exposure_value
            if ($dosis === null) {
                $exposure_level = 'Tidak Ada';
            } elseif ($dosis <= 4.428) {
                $exposure_level = 'Baik';
            } elseif ($dosis >= 4.428 && $dosis < 15.83) {
                $exposure_level = 'Sedang';
            } elseif ($dosis >= 15.83 && $dosis < 42.97) {
                $exposure_level = 'Tidak Sehat';
            } elseif ($dosis >= 42.97 && $dosis < 71.54) {
                $exposure_level = 'Sangat Tidak Sehat';
            } elseif ($dosis >= 71.54) {
                $exposure_level = 'Berbahaya';
            }
            $recommendationTime = now()->format('H:i, M d'); // Waktu saat ini sebagai contoh

        }

        return view('index3', [
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
