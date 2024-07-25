<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThingSpeakData extends Model
{
    use HasFactory;

    // Tentukan kolom yang dapat diisi secara massal
    protected $fillable = [
        'pm25',
        'pm10',
        'temperature',
        'humidity',
        'tvoc',
        'eco2',
        'pressure',
    ];
}
