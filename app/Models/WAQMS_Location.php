<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WAQMS_Location extends Model
{
    protected $table = 'waqms_location';
    public $timestamps = false;
    protected $fillable = ['id', 'created_at', 'longitude', 'latitude'];

    use HasFactory;
}
