<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\ThingSpeakData;
use App\Models\WAQMS_Valid;
use Carbon\Carbon;


class ParameterController extends Controller
{
    public function index()
    {
        $day1ago = Carbon::now();
        $day2ago = Carbon::now()->subDay();
        $data = WAQMS_Valid::whereBetween('created_at', [$day2ago, $day1ago])
            ->orderBy('created_at', 'asc')
            ->get();
        return response()->json($data);
    }
    public function Kodular()
    {
        $data = WAQMS_Valid::orderBy('created_at', 'desc')->first();
        return response()->json($data);
    }
}
