<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function download()
    {
        $filePath = 'public/WAQMS_AirGradient.apk';
        $fileName = 'WAQMS_AirGradient.apk';

        if (Storage::exists($filePath)) {
            return Storage::download($filePath, $fileName);
        } else {
            return redirect()->back()->with('error', 'File not found.');
        }
    }
}
