<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WAQMS_Valid extends Model
{
    protected $table = 'waqms_valid';
    public $timestamps = false;
    protected $fillable = ['id', 'created_at', 'pm25', 'pm10', 'eco2', 'tvoc', 'temperature', 'humidity', 'pressure'];
    use HasFactory;
}
