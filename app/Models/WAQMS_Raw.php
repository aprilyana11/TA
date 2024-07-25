<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WAQMS_Raw extends Model
{
    use HasFactory;
    protected $table = 'waqms_raw';

    protected $fillable = ['id', 'created_at', 'pm25', 'pm10', 'eco2', 'tvoc', 'temperature', 'humidity', 'pressure'];
}
