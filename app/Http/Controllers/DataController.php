<?php

namespace App\Http\Controllers;

use App\Models\WAQMS_Location;
use App\Models\WAQMS_Raw;
use App\Models\WAQMS_Valid;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function History(Request $request)
    {
        $start_time = Carbon::parse($request->start_time);
        $stop_time = Carbon::parse($request->stop_time);

        $data = [];

        switch ($request->type) {

            case 'raw':
                $data = WAQMS_Raw::whereBetween('created_at', [$start_time, $stop_time])->get();
                break;
            case 'valid':
                $data = WAQMS_Valid::whereBetween('created_at', [$start_time, $stop_time])->get();
                break;
            default:
                return response()->json(['error' => 'Invalid data type'], 400);
        }


        // Kirim data ke view
        return response()->json($data);
    }
}
