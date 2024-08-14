<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class DownloadController extends Controller
{
    public function download()
    {
        $filePath = 'public/APLIKASIAIRGRADIEN.apk';
        $fileName = 'APLIKASIAIRGRADIEN.apk';

        if (Storage::exists($filePath)) {
            // Force download with the correct MIME type
            return Storage::download($filePath, $fileName, [
                'Content-Type' => 'application/vnd.android.package-archive',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]);
        } else {
            return redirect()->back()->with('error', 'File not found.');
        }
    }
}
