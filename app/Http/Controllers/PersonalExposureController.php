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
            $doseCalculate = '-';
            // Data ditampilkan di view
            $exposure_level = '-'; // harus diubah sesuai dengan logika
            $recommendationTime = now()->format('H:i, M d'); // Waktu saat ini sebagai contoh

        } else {
            $pm25Dose = WAQMS_Valid::whereBetween('created_at', [$yesterday1, $yesterday2])->pluck('pm25');;

            // Cek apakah jumlah data setidaknya 45
            if ($pm25Dose->count() >= 45) { //1jam * 60 data / 1 jamnya 75% 
                // Hitung rata-rata dari data 'pm25'
                $pm25Average = $pm25Dose->average();
                $doseCalculate = ($pm25Average * 0.83 * 1 * 1) / $weight;
                $doseCalculate = number_format($doseCalculate, 3);
            } else {
                // Jika kurang dari 45 data, set $pm25Average menjadi null
                $pm25Average = null;
            }

            $exposure_level = '-';

            // Tentukan level paparan berdasarkan exposure_value
            if ($dose === null) {
                $exposure_level = 'Tidak Ada';
            } elseif ($doseCalculate <= $dose) {
                $exposure_level = 'Sangat Aman';
            } elseif ($doseCalculate > $dose && $doseCalculate <= 0.2) {
                $exposure_level = 'Aman';
            } else {
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
