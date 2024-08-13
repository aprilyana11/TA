<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function download()
    {
        $filePath = 'public/APLIKASIAIRGRADIEN.apk';
        $fileName = 'APLIKASIAIRGRADIEN.apk';

        if (Storage::exists($filePath)) {
            return Storage::download($filePath, $fileName);
        } else {
            return redirect()->back()->with('error', 'File not found.');
        }
    }
}
