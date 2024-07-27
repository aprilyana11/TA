<?php

namespace App\Http\Controllers;

use App\Models\WAQMS_Location;
use App\Models\WAQMS_Raw;
use App\Models\WAQMS_Valid;
use Illuminate\Http\Request;

class SendDataController extends Controller
{
    public function send(Request $request)
    {
        $data = $request->all();

        // Create entry in WAQMS_Raw
        WAQMS_Raw::create($data);

        // Nullify values outside specified ranges
        if (isset($data['tvoc']) && ($data['tvoc'] < 0 || $data['tvoc'] > 60000)) {
            $data['tvoc'] = null;
        }
        if (isset($data['eco2']) && ($data['eco2'] < 400 || $data['eco2'] > 60000)) {
            $data['eco2'] = null;
        }
        if (isset($data['pm25']) && ($data['pm25'] < 0 || $data['pm25'] > 1000)) {
            $data['pm25'] = null;
        }
        if (isset($data['humidity']) && $data['humidity'] >= 80 && isset($data['pm25'])) {
            $data['pm25'] = $data['pm25'] * 0.67;
        }
        if (isset($data['pm10']) && ($data['pm10'] < 0 || $data['pm10'] > 1000)) {
            $data['pm10'] = null;
        }
        if (isset($data['temperature']) && ($data['temperature'] < -40 || $data['temperature'] > 85)) {
            $data['temperature'] = null;
        }
        if (isset($data['humidity']) && ($data['humidity'] < 0 || $data['humidity'] > 100)) {
            $data['humidity'] = null;
        }
        if (isset($data['pressure']) && ($data['pressure'] < 300 || $data['pressure'] > 1100)) {
            $data['pressure'] = null;
        }

        // Create entry in WAQMS_Valid
        WAQMS_Valid::create($data);

        WAQMS_Location::create($data);

        return response()->json(['message' => 'Data processed successfully.']);
    }
}
