<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WAQMSLocationSeeder extends Seeder
{
    public function run()
    {
        $startDate = Carbon::create(2024, 1, 1, 0, 0, 0); // Start date
        $endDate = Carbon::create(2024, 12, 31, 23, 59, 0); // End date

        $interval = 2; // Interval in minutes
        $locations = [];

        $currentDate = $startDate;

        while ($currentDate->lessThanOrEqualTo($endDate)) {
            $locations[] = [
                'created_at' => $currentDate->toDateTimeString(), // Corrected to use $currentDate
                'longitude' => $this->generateRandomLongitude(),
                'latitude' => $this->generateRandomLatitude()
            ];
            $currentDate->addMinutes($interval);
        }

        // Insert data in chunks to avoid memory issues
        $chunks = array_chunk($locations, 500); // Adjust chunk size as necessary
        foreach ($chunks as $chunk) {
            DB::table('waqms_location')->insert($chunk);
        }
    }

    private function generateRandomLongitude()
    {
        // Longitude centered around 107.6316854 with a small random offset
        return 107.6316854 + mt_rand(-500, 500) / 100000;
    }

    private function generateRandomLatitude()
    {
        // Latitude centered around -6.973007 with a small random offset
        return -6.973007 + mt_rand(-500, 500) / 100000;
    }
}
