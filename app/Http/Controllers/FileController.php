<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController extends Controller
{
    public function download($fileId)
    {
        $file = File::findOrFail($fileId);

        // Získať úplnú cestu k súboru v storage
        $path = 'public/' . strtolower(class_basename($file->fileable_type)) . '/' . $file->fileable_id . '/' . $file->filename;

        // Skontrolovať, či súbor existuje
        if (!Storage::exists($path)) {
            abort(404, 'File not found');
        }

        // Vrátiť súbor na stiahnutie
        return Storage::download($path, $file->name . '.' . $file->extension);
    }
}
