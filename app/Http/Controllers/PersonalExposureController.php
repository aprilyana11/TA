<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PersonalExposure;
use App\Models\User;
use App\Models\WAQMS_Valid;
// use Carbon\Carbon;


class PersonalExposureController extends Controller
{
    public function showPersonalExposure()
    {
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

        $intensity = 20; // nilai inhalasi, disesuaikan dengan data (cari relasi antara bb dengan IR)
        $activityFactor = 1; // nilai faktor aktivitas
        $residenceFactor = 1; // nilai faktor residensi
        $pm25 = $data['pm25'];
        // Hitung dosis paparan
        $dose = $pm25 * $intensity * $activityFactor * $residenceFactor / $weight;

        // Data ditampilkan di view
        $exposure_level = 'Tidak sehat bagi kelompok sensitif'; // harus diubah sesuai dengan logika
        $exposureValue = round($dose); // Pembulatan dosis
        $recommendationTime = now()->format('H:i, M d'); // Waktu saat ini sebagai contoh

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

    private function getPM25Concentration()
    {
        // Channel ID dan API Key dari Thingspeak
        // $channelId = 'YOUR_CHANNEL_ID';
        // $apiKey = 'YOUR_API_KEY';

        // URL untuk mengambil data dari Thingspeak
        // $url = "https://api.thingspeak.com/channels/$channelId/fields/1/last.json?api_key=$apiKey";

        // Mengambil data dari Thingspeak menggunakan file_get_contents()
        // $response = file_get_contents($url);

        // Menangani response JSON
        // $data = json_decode($response, true);

        // Memeriksa apakah data berhasil diambil
        // if (isset($data['field1'])) {
        // Mengambil nilai konsentrasi PM2.5 dari response
        // $concentration = $data['field1'];
        // return $concentration;
        // } else {
        // Gagal mengambil nilai konsentrasi PM2.5 dari Thingspeak
        // return null;
        // }
    }
}
