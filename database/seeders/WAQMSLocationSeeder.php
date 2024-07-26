<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WAQMSLocationSeeder extends Seeder
{
    public function run()
    {
        $locations = [];
        $currentTime = Carbon::now();
        $startTime = $currentTime->copy()->subWeek();

        while ($startTime->lessThan($currentTime)) {
            $locations[] = [
                'created_at' => $startTime->toDateTimeString(),
                'longitude' => $this->generateRandomLongitude(),
                'latitude' => $this->generateRandomLatitude()
            ];
            $startTime->addMinutes(10);
        }

        DB::table('waqms_location')->insert($locations);
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
