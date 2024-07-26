<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WAQMS_Location;
use Carbon\Carbon;

class TrackingController extends Controller
{
    public function index()
    {
        // Ambil data dari satu jam yang lalu hingga sekarang
        $oneHourAgo = Carbon::now()->subHour();
        $locations = WAQMS_Location::where('created_at', '>=', $oneHourAgo)
            ->orderBy('created_at', 'asc')
            ->get(['latitude', 'longitude', 'created_at']);

        // Kirim data ke view
        return response()->json($locations);
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
