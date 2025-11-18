<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileSystemService
{
    /**
     * Get the relative path for the upload.
     *
     * @param string $entityPath
     * @return string
     */
    public function getUploadRelativePath(string $entityPath): string
    {
        $dateTime = now();

        return "uploads/{$entityPath}/{$dateTime->format('M-Y')}/";
    }

    /**
     * Upload a file to the specified entity path.
     *
     * @param UploadedFile $uploadedFile
     * @param string $entityPath
     * @return array
     */
    public function uploadFile(UploadedFile $uploadedFile, string $entityPath): array
    {
        $fileName = (string) Str::uuid();
        $extension = $uploadedFile->getClientOriginalExtension();
        $fileSize = $uploadedFile->getSize();
        $relativePath = $this->getUploadRelativePath($entityPath);

        if ($extension) {
            $fileName = "{$fileName}.{$extension}";
        }

        Storage::disk('public')->makeDirectory($relativePath);

        $filePath = $relativePath . $fileName;
        Storage::disk('public')->putFileAs($relativePath, $uploadedFile, $fileName);
        return [
            "fileName" => $fileName,
            "fileSize" => $fileSize,
            "fileUrl" => $filePath,
        ];
    }

    /**
     * Remove a file from storage.
     *
     * @param string $filePath
     * @return void
     */
    public function removeFile(string $filePath): void
    {
        if (!empty($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
    }
}
