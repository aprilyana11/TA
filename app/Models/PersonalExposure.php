<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalExposure extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pm25',
        'pm10',
        'temperature',
        'humidity',
        'tvoc',
        'eco2',
        'pressure',
        'exposure_dose'
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Menghitung dosis paparan berdasarkan rumus yang diberikan
    public function calculateExposureDose($C, $IR, $FA, $FR, $BW)
    {
        return ($C * $IR * $FA * $FR) / $BW;
    }
}
