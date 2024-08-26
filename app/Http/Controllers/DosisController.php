<?php

namespace App\Http\Controllers;

use App\Models\dosis;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DosisController extends Controller
{
    public function index(Request $request)
    {
        dosis::create($request->all());
    }
    public function read() {}
}
