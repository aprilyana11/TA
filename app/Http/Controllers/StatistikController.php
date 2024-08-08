<?php

namespace App\Http\Controllers;

use App\Models\WAQMS_Raw;
use App\Models\WAQMS_Valid;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatistikController extends Controller
{
    public function index($parameter, Request $request)
    {
        // Set the start and stop time
        $time_start = $request->time_start ? Carbon::parse($request->time_start) : Carbon::now();
        $time_stop = $request->time_stop ? Carbon::parse($request->time_stop) : Carbon::now()->subDay();

        // Define the valid parameters
        $params = ['pm25', 'pm10', 'temperature', 'humidity', 'tvoc', 'eco2', 'pressure'];

        if (in_array($parameter, $params)) {
            // Retrieve raw data within the time range
            $raw_data = WAQMS_Raw::whereBetween('created_at', [$time_start, $time_stop])
                ->pluck($parameter);

            // Retrieve valid data within the time range
            $valid_data = WAQMS_Valid::whereBetween('created_at', [$time_start, $time_stop])
                ->pluck($parameter);

            // Count the number of entries for raw and valid data
            $raw_count = $raw_data->count();
            $valid_count = $valid_data->count();

            // Calculate the time difference in minutes
            $time_difference = $time_start->diffInMinutes($time_stop);

            // Prepare the result array
            $result = [
                'Waktu Mulai' => $time_start->toDateTimeString(),
                'Waktu Akhir' => $time_stop->toDateTimeString(),
                'Parameter' => $parameter,
                'Data Raw' => $raw_count,
                'Data Valid' => $valid_count,
                'Data Seharusnya' => $time_difference,
            ];

            // Return the result as JSON
            return response()->json($result);
        } else {
            // Return an error response if the parameter is not valid
            return response()->json(['error' => 'Invalid parameter'], 400);
        }
    }
}
