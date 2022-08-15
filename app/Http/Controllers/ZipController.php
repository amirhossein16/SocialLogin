<?php

// Route::get('zip', [ZipController::class, 'index']);

namespace App\Http\Controllers;

use File;
use ZipArchive;
use Illuminate\Http\Request;

class ZipController extends Controller
{
    public function index()
    {
        $zip = new ZipArchive;

        $fileName = 'zipFileName.zip';

        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
        {
            // Folder files to zip and download
            // files folder must be existing to your public folder
            $files = File::files(public_path('files'));

            // loop the files result
            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $zip->addFile($value, $relativeNameInZipFile);
            }

            $zip->close();
        }

        // Download the generated zip
        return response()->download(public_path($fileName));
    }
}
