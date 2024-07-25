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
        $data = DB::table('waqms')
            ->whereBetween('created_at', [$oneHourAgo, $now])
            ->orderBy('created_at')
            ->get();

        // Pass the data to the view
        return response()->json($data);
    }
}
