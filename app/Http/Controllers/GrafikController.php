<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GrafikController extends Controller
{
    public function index()
    {
        $now = Carbon::now('Asia/Jakarta');
        $oneHourAgo = $now->copy()->subHour();

        // Retrieve data from the database
        $data = DB::table('waqms_valid')
            ->whereBetween('created_at', [$oneHourAgo, $now])
            ->orderBy('created_at')
            ->get();

        // Pass the data to the view
        return response()->json($data);
    }
    public function per_jam()
    {
        $now = Carbon::now('Asia/Jakarta');
        $reset_day = $now->copy()->startOfDay();

        // Retrieve and aggregate data from the database with rounding
        $data = DB::table('waqms_valid')
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:00:00") as created_at'),
                DB::raw('ROUND(AVG(tvoc), 0) as tvoc'),
                DB::raw('ROUND(AVG(eco2), 0) as eco2'),
                DB::raw('ROUND(AVG(pm25), 0) as pm25'),
                DB::raw('ROUND(AVG(pm10), 0) as pm10'),
                DB::raw('ROUND(AVG(temperature), 0) as temperature'),
                DB::raw('ROUND(AVG(humidity), 0) as humidity'),
                DB::raw('ROUND(AVG(pressure), 0) as pressure')
            )
            ->whereBetween('created_at', [$reset_day, $now])
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:00:00")'))
            ->orderBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:00:00")'))
            ->get();

        // Pass the aggregated data to the view
        return response()->json($data);
    }
    public function per_day()
    {
        $now = Carbon::now('Asia/Jakarta');
        $reset_day = $now->copy()->startOfWeek();

        // Retrieve and aggregate data from the database with rounding
        $data = DB::table('waqms_valid')
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d 00:00:00") as created_at'),
                DB::raw('ROUND(AVG(tvoc), 0) as tvoc'),
                DB::raw('ROUND(AVG(eco2), 0) as eco2'),
                DB::raw('ROUND(AVG(pm25), 0) as pm25'),
                DB::raw('ROUND(AVG(pm10), 0) as pm10'),
                DB::raw('ROUND(AVG(temperature), 0) as temperature'),
                DB::raw('ROUND(AVG(humidity), 0) as humidity'),
                DB::raw('ROUND(AVG(pressure), 0) as pressure')
            )
            ->whereBetween('created_at', [$reset_day, $now])
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d 00:00:00")'))
            ->orderBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d 00:00:00")'))
            ->get();

        // Pass the aggregated data to the view
        return response()->json($data);
    }
}
