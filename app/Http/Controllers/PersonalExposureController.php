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

        // Data contoh untuk perhitungan
        // $concentration = 100; // nilai konsentrasi, ini nanti diganti dengan data dari Thingspeak

        // Ambil nilai konsentrasi PM2.5 dari Thingspeak
        // $concentration = $this->getPM25Concentration();
        $concentration = [];

        // Jika gagal mendapatkan nilai dari Thingspeak, gunakan nilai default

        $intensity = 0; // nilai inhalasi, disesuaikan dengan data (cari relasi antara bb dengan IR)
        $activityFactor = 1; // nilai faktor aktivitas
        $residenceFactor = 1; // nilai faktor residensi
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
            if ($pm25Dose->count() >= 480) {
                // Hitung rata-rata dari data 'pm25'
                $pm25Average = $pm25Dose->average();
                $dose    = $pm25Average * $intensity * $activityFactor * $residenceFactor / $weight;
            } else {
                // Jika kurang dari 480 data, set $pm25Average menjadi null
                $pm25Average = null;
                $dose = null;
            }


            $exposure_level = null;
            // Tentukan level paparan berdasarkan exposure_value
            if ($dose === null) {
                $exposure_level = 'Tidak Ada';
            } elseif ($dose <= 0.01) {
                $exposure_level = 'rendah';
            } elseif ($dose >= 0.01 && $dose < 0.05) {
                $exposure_level = 'Sedang';
            } elseif ($dose >= 0.05 && $dose < 0.10) {
                $exposure_level = 'Tinggi';
            } elseif ($dose >= 0.10) {
                $exposure_level = 'Sangat Tinggi';
            }

            // Data ditampilkan di view
            $exposureValue = $dose ? $dose : null; // Pembulatan dosis
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
