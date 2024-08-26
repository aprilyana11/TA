<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dosis extends Model
{
    use HasFactory;
    protected $table = 'dosis';
    public $timestamps = false;
    protected $fillable = ['id', 'created_at', 'dosis'];
}
