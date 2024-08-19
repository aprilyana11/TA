<?php

namespace App\Http\Controllers;

use App\Models\WAQMS_Raw;
use App\Models\WAQMS_Valid;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    public function History(Request $request)
    {
        $start_time = Carbon::parse($request->start_time);
        $stop_time = Carbon::parse($request->stop_time);

        $data = [];

        switch ($request->type) {
            case 'raw':
                $data = WAQMS_Raw::whereBetween('created_at', [$start_time, $stop_time])
                    ->select(
                        DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:%i:00") as time'),
                        DB::raw('AVG(pm25) as pm25'),
                        DB::raw('AVG(pm10) as pm10'),
                        DB::raw('AVG(temperature) as temperature'),
                        DB::raw('AVG(humidity) as humidity'),
                        DB::raw('AVG(tvoc) as tvoc'),
                        DB::raw('AVG(eco2) as eco2'),
                        DB::raw('AVG(pressure) as pressure')
                    )
                    ->groupBy('time')
                    ->get();
                break;
            case 'valid':
                $data = WAQMS_Valid::whereBetween('created_at', [$start_time, $stop_time])
                    ->select(
                        DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:%i:00") as time'),
                        DB::raw('AVG(pm25) as pm25'),
                        DB::raw('AVG(pm10) as pm10'),
                        DB::raw('AVG(temperature) as temperature'),
                        DB::raw('AVG(humidity) as humidity'),
                        DB::raw('AVG(tvoc) as tvoc'),
                        DB::raw('AVG(eco2) as eco2'),
                        DB::raw('AVG(pressure) as pressure')
                    )
                    ->groupBy('time')
                    ->get();
                break;
            default:
                return response()->json(['error' => 'Invalid data type'], 400);
        }

        // Kirim data ke view
        return response()->json($data);
    }
}
