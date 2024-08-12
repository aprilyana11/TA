<?php

namespace App\Http\Controllers;

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
        $yesterday1 = Carbon::now()->subDay()->startOfDay();
        $yesterday2 = Carbon::now()->subDay()->endOfDay();
        $data = WAQMS_Valid::latest('created_at')->first();

        // Ambil data dari database
        $user = Auth::user();
        $weight = $user->weight; // Berat badan dari user


        // $concentration = $this->getPM25Concentration();
        $concentration = [];
        // Menentukan Intake Rate berdasarkan usia
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

        // Gunakan $intensity, $activityFactor, dan $residenceFactor dalam perhitungan dosis
        $dose = $intensity * $activityFactor * $residenceFactor / $weight;


        // Jika gagal mendapatkan nilai dari Thingspeak, gunakan nilai default

        if ($data === null) {
            $pm25 = null;
            $data['created_at'] = '-';
            $data['pm25'] = '-';
            $data['pm10'] = '-';
            $data['temperature'] = '-';
            $data['humidity'] = '-';
            $data['pressure'] = '-';
            $data['tvoc'] = '-';
            $data['eco2'] = '-';
            $dose = '-';
            // Data ditampilkan di view
            $exposure_level = '-'; // harus diubah sesuai dengan logika
            $exposureValue = '-';
            $recommendationTime = now()->format('H:i, M d'); // Waktu saat ini sebagai contoh

        } else {
            $pm25Dose = WAQMS_Valid::whereBetween('created_at', [$yesterday1, $yesterday2])->pluck('pm25');;

            // Cek apakah jumlah data setidaknya 480
            if ($pm25Dose->count() >= 480) { //1 hari yang lalu, 24 jam * 60 data / 1 jamnya 75% 
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
        }

        // Hitung dosis paparan



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
            'exposureValue' => $exposureValue,
            'recommendationTime' => $recommendationTime
        ]);
    }
}
