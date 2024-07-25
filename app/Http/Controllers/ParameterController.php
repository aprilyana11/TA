<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\ThingSpeakData;

class ParameterController extends Controller
{
    public function fetchData()
    {
        $channelId = '2592355'; // Ganti dengan channel ID ThingSpeak Anda
        $readApiKey = '8DT6JC52VCZATDFN'; // Ganti dengan read API key ThingSpeak Anda

        try {
            // Ambil data dari API ThingSpeak
            $response = Http::get("https://api.thingspeak.com/channels/{2592355}/feeds.json", [
                'api_key' => $readApiKey,
                'results' => 1,
            ]);

            // Periksa jika permintaan gagal
            if ($response->failed()) {
                return response()->json(['error' => 'Unable to fetch data from ThingSpeak'], 500);
            }

            // Ambil data JSON dari respons
            $data = $response->json();

            // Periksa jika data feeds ada
            $feed = $data['feeds'][0] ?? [];

            if (empty($feed)) {
                return response()->json(['error' => 'No data found in the feed'], 404);
            }

            // Simpan data ke database
            ThingSpeakData::create([
                'pm25' => $feed['field1'] ?? null,
                'pm10' => $feed['field2'] ?? null,
                'temperature' => $feed['field3'] ?? null,
                'humidity' => $feed['field4'] ?? null,
                'tvoc' => $feed['field5'] ?? null,
                'eco2' => $feed['field6'] ?? null,
                'pressure' => $feed['field7'] ?? null,
            ]);

            // Kembalikan tampilan dengan data
            return view('dashboard', ['feed' => $feed]);
        } catch (\Exception $e) {
            // Tangani exception dan kembalikan pesan kesalahan
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}
