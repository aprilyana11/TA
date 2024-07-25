<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WAQMSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $startDate = Carbon::create(2024, 1, 1, 0, 0, 0); // Mulai dari 2024-01-01 00:00:00
        $endDate = Carbon::create(2024, 12, 31, 23, 59, 0); // Akhir tahun 2024
        $interval = 2; // Interval dalam menit

        $data = [];
        $currentDate = $startDate;

        while ($currentDate->lessThanOrEqualTo($endDate)) {
            $data[] = [
                'created_at' => $currentDate->toDateTimeString(), // Format timestamp untuk created_at
                'pm25' => number_format(rand(50, 1000) / 10, 2), // Nilai acak antara 5.0 dan 100.0
                'pm10' => number_format(rand(50, 1000) / 10, 2), // Nilai acak antara 5.0 dan 100.0
                'temperature' => number_format(rand(-100, 500) / 10, 1), // Nilai acak antara -10.0 dan 50.0
                'humidity' => number_format(rand(0, 1000) / 10, 1), // Nilai acak antara 0.0 dan 100.0
                'tvoc' => number_format(rand(500, 3000) / 10, 1), // Nilai acak antara 50.0 dan 300.0
                'eco2' => rand(400, 2000), // Nilai acak antara 400 dan 2000
                'pressure' => number_format(rand(900, 1100) / 10, 1), // Nilai acak antara 90.0 dan 110.0
            ];
            $currentDate->addMinutes($interval);
        }

        $chunks = array_chunk($data, 1000);
        foreach ($chunks as $chunk) {
            DB::table('waqms_valid')->insert($chunk);
        }
    }
}
