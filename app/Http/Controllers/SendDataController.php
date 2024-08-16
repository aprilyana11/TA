<?php

namespace App\Http\Controllers;

use App\Models\WAQMS_Location;
use App\Models\WAQMS_Raw;
use App\Models\WAQMS_Valid;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SendDataController extends Controller
{
    public function send(Request $request)
    {
        // Create entry in WAQMS_Raw
        WAQMS_Raw::create($request->all());

        // Nullify values outside specified ranges
        $data = $request->all();
        Log::channel('validation')->info("Mendeteksi Out Of Range pada timestamp :" . $data['created_at']);
        if (isset($data['tvoc']) && ($data['tvoc'] < 0 || $data['tvoc'] > 60000)) {
            Log::channel('validation')->info("Terdeteksi Out Of Range TVOC :" . $data['tvoc']);
            $data['tvoc'] = null;
        }
        if (isset($data['eco2']) && ($data['eco2'] < 400 || $data['eco2'] > 60000)) {
            Log::channel('validation')->info("Terdeteksi Out Of Range eco2 :" . $data['eco2']);
            $data['eco2'] = null;
        }
        if (isset($data['pm25']) && ($data['pm25'] < 0 || $data['pm25'] > 1000)) {
            Log::channel('validation')->info("Terdeteksi Out Of Range pm25 :" . $data['pm25']);
            $data['pm25'] = null;
        }
        if (isset($data['humidity']) && $data['humidity'] >= 80 && isset($data['pm25'])) {
            Log::channel('validation')->info("Terdeteksi Humidity diatas 80% dengan nilai PM25 :" . $data['pm25']);
            $data['pm25'] = $data['pm25'] * 0.67;
        }
        if (isset($data['pm10']) && ($data['pm10'] < 0 || $data['pm10'] > 1000)) {
            Log::channel('validation')->info("Terdeteksi Out Of Range pm10 :" . $data['pm10']);
            $data['pm10'] = null;
        }
        if (isset($data['temperature']) && ($data['temperature'] < -40 || $data['temperature'] > 85)) {
            Log::channel('validation')->info("Terdeteksi Out Of Range temperature :" . $data['temperature']);
            $data['temperature'] = null;
        }
        if (isset($data['humidity']) && ($data['humidity'] < 0 || $data['humidity'] > 100)) {
            Log::channel('validation')->info("Terdeteksi Out Of Range humidity :" . $data['humidity']);
            $data['humidity'] = null;
        }
        if (isset($data['pressure']) && ($data['pressure'] < 300 || $data['pressure'] > 1100)) {
            Log::channel('validation')->info("Terdeteksi Out Of Range pressure :" . $data['pressure']);
            $data['pressure'] = null;
        }

        // Create entry in WAQMS_Valid and WAQMS_Location
        WAQMS_Valid::create($data);
        WAQMS_Location::create($data);

        // Call the Validasi method
        $this->validasi();
        $data = [];

        // return response()->json(['message' => 'Data processed successfully.', 'validData' => $validData]);
    }


    public function validasi()
    {
        Log::channel('validation')->info("====================VALIDATION====================");

        // Set time range for validation
        $jam_low = Carbon::now('Asia/Jakarta')->subHour()->startOfMinute();
        $jam_high = Carbon::now('Asia/Jakarta')->endOfMinute();

        $data = WAQMS_Valid::whereBetween('created_at', [$jam_low, $jam_high])->get();
        Log::channel('validation')->info("Validation window: " . $jam_low . " - " . $jam_high);

        Log::channel('validation')->info("Retrieved Data:");
        foreach ($data as $record) {
            Log::channel('validation')->info("Time: $record->created_at | T: $record->temperature | RH: $record->humidity | PM2.5: $record->pm25 | PM10: $record->pm10 | eCO2: $record->eco2 | TVOC: $record->tvoc");
        }

        $parameters = ['temperature', 'humidity', 'pm25', 'pm10', 'eco2', 'tvoc'];

        // Apply outlier filtering for each parameter
        foreach ($parameters as $parameter) {
            $data = $this->outlier($data, $parameter);
        }

        // Convert data to array
        $validData = $data->toArray();

        foreach ($validData as $entry) {
            // Use updateOrCreate to handle duplicates
            WAQMS_Valid::updateOrCreate(
                ['created_at' => $entry['created_at']], // Attributes to search for
                [
                    'temperature' => $entry['temperature'],
                    'humidity' => $entry['humidity'],
                    'pm25' => $entry['pm25'],
                    'pm10' => $entry['pm10'],
                    'eco2' => $entry['eco2'],
                    'tvoc' => $entry['tvoc'],
                ]
            );
        }

        return $validData;
    }

    private function outlier($data, $parameter)
    {
        $dataArray = $data->toArray();

        // Filter data based on the parameter
        $filteredData = array_filter($dataArray, function ($record) use ($parameter) {
            return isset($record[$parameter]) && !is_null($record[$parameter]);
        });
        Log::channel('validation')->info("Checking Outlier for $parameter \n");
        if (count($filteredData) > 45) { //Outlier Per 1 jam
            $n = count($filteredData);
            Log::channel('validation')->info("Detected $parameter data count $n > 45 per hour\n");

            $params = array_column($filteredData, $parameter);
            sort($params);

            // Quartile calculation function
            $q1 = $this->quartile($params, 0.25);
            $q2 = $this->quartile($params, 0.5);
            $q3 = $this->quartile($params, 0.75);
            $iqr = $q3 - $q1;
            $low = $q1 - ($iqr * 1.5);
            $high = $q3 + ($iqr * 1.5);

            // Output quartiles
            Log::channel('validation')->info("First Quartile (Q1): $q1");
            Log::channel('validation')->info("Second Quartile (Q2): $q2");
            Log::channel('validation')->info("Third Quartile (Q3): $q3");
            Log::channel('validation')->info("IQR: $iqr");
            Log::channel('validation')->info("Lower outlier: $low");
            Log::channel('validation')->info("Upper outlier: $high \n");

            $i = 0;
            foreach ($data as $record) {
                if ($record->$parameter < $low || $record->$parameter > $high) {
                    Log::channel('validation')->info("Detected $parameter outlier at $record->created_at with value $record->$parameter");
                    $record->$parameter = null;
                    $i += 1;
                }
            }
            Log::channel('validation')->info("\n");
            Log::channel('validation')->info("Number of discarded data points: $i\n");

            return $data;
        } else {
            $n = count($filteredData);
            Log::channel('validation')->info("Retrieved $n data points, less than 45! Skipping outlier method\n");
            return $data;
        }
    }

    private function quartile($data, $quartile)
    {
        $count = count($data);
        $pos = ($count - 1) * $quartile;
        $base = floor($pos);
        $fraction = $pos - $base;

        if ($count > 1) {
            return $data[$base] + $fraction * ($data[$base + 1] - $data[$base]);
        } else {
            return $data[0];
        }
    }
}
