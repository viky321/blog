<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\File;

class UploadService
{
    /**
     * nahranie a ulozenie suboru pre akykolvek model
     *
     * @param UploadedFile $file
     * @param mixed $model
     * @return File
     */
    public function saveFile(UploadedFile $file, $model)
    {
        // info o modeli
        $modelName = class_basename($model);
        $modelId = $model->id;

        // generovanie unikatny nazov kodu
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $uniqueName = $originalName . '-' . uniqid() . '.' . $extension;

        // cesta k uloženiu suboru
        $path = strtolower($modelName) . '/' . $modelId;

        // ulozenie suboru do uložiska
        $file->storeAs($path, $uniqueName, 'public');

        // uložime zaznam do databazy
        return $this->addFileToDatabase($file, $uniqueName, $model);
    }

    /**
     * pridame zaznam o subore do databazy
     *
     * @param UploadedFile $file
     * @param string $filename
     * @param mixed $model
     * @return File
     */
    protected function addFileToDatabase(UploadedFile $file, $filename, $model)
    {
        return File::create([
            'name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'filename' => $filename,
            'mimes' => $file->getMimeType(),
            'extension' => $file->getClientOriginalExtension(),
            'size' => $file->getSize(),
            'fileable_type' => get_class($model),
            'fileable_id' => $model->id,
        ]);
    }

    public function deleteFiles($model)
    {
        $modelName = strtolower(class_basename($model));
        $directoryPath = $modelName . '/' . $model->id;

        foreach ($model->files as $file) {
            $filePath = $directoryPath . '/' . $file->filename;
            \Log::info('Attempting to delete file: ' . $filePath);

            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
                \Log::info('Deleted file: ' . $filePath);
            } else {
                \Log::warning('File not found: ' . $filePath);
            }

            $file->delete();
        }

        if (Storage::disk('public')->exists($directoryPath)) {
            $files = Storage::disk('public')->allFiles($directoryPath);
            \Log::info('Files remaining in directory: ' . json_encode($files));

            if (empty($files)) {
                Storage::disk('public')->deleteDirectory($directoryPath);
                \Log::info('Deleted directory: ' . $directoryPath);
            } else {
                \Log::info('Directory not empty: ' . $directoryPath);
            }
        }

    }
}
