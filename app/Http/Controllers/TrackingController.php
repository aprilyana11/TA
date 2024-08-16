<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WAQMS_Location;
use App\Models\WAQMS_Valid;
use Carbon\Carbon;

class TrackingController extends Controller
{
    public function index()
    {
        // Ambil data dari satu hari yang lalu hingga sekarang
        $oneDayAgo = Carbon::now()->subDay();
        $now = Carbon::now();
        // Ambil lokasi berdasarkan waktu
        $locations = WAQMS_Location::whereBetween('created_at', [$oneDayAgo, $now])
            ->orderBy('created_at', 'asc')
            ->get(['latitude', 'longitude', 'created_at']);

        $data = WAQMS_Valid::whereBetween('created_at', [$oneDayAgo, $now])
            ->orderBy('created_at', 'asc')
            ->get(['pm25', 'pm10', 'temperature', 'humidity', 'tvoc', 'eco2', 'pressure', 'created_at']);

        $mergedData = $locations->map(function ($location) use ($data) {
            $matchingData = $data->firstWhere('created_at', $location->created_at);

            return [
                'latitude' => $location->latitude,
                'longitude' => $location->longitude,
                'created_at' => $location->created_at,
                'pm25' => optional($matchingData)->pm25,
                'pm10' => optional($matchingData)->pm10,
                'temperature' => optional($matchingData)->temperature,
                'humidity' => optional($matchingData)->humidity,
                'tvoc' => optional($matchingData)->tvoc,
                'eco2' => optional($matchingData)->eco2,
                'pressure' => optional($matchingData)->pressure,
            ];
        });

        // Kirim data ke view sebagai JSON
        return response()->json($mergedData);
    }


    public function database()
    {
        $day7ago = Carbon::now()->subWeek();
        $locations = WAQMS_Location::where('created_at', '>=', $day7ago)
            ->orderBy('created_at', 'desc')
            ->get(['latitude', 'longitude', 'created_at']);
        return response()->json($locations);
    }
}
