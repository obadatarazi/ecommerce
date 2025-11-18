<?php

namespace App\Services;

class UploadFileService
{

    public function __construct(protected FileSystemService $fileSystemService)
    {

    }

    public function uploadFiles($data, $keyFileMaps, $object, $folder): void
    {

        foreach ($keyFileMaps as $fileModelKey => $fileRequestKey) {
            if (isset($data[$fileRequestKey]) && is_object($data[$fileRequestKey])) {
                $fileField = $this->fileSystemService->uploadFile($data[$fileRequestKey], $folder);
                $object->setAttribute($fileModelKey, $fileField['fileUrl']);
            }

        }

    }

    public function updateFiles($data, $keyFileMaps, $object, $folder): void
    {
        foreach ($keyFileMaps as $fileModelKey => $fileRequestKey) {

            if (!array_key_exists($fileRequestKey, $data)) {
                continue;
            }

            $file = $data[$fileRequestKey];
            $oldFilePath = $object->getAttribute($fileModelKey);
            if ($oldFilePath) {
                $this->removeFiles($oldFilePath);
            }

             if (is_object($file)) {
                $fileField = $this->fileSystemService->uploadFile($file, $folder);
                $object->setAttribute($fileModelKey, $fileField['fileUrl']);
            } else {
                $object->setAttribute($fileModelKey, null);
            }
        }
    }

    public function removeFiles($paths): void
    {
        if (is_array($paths)) {
            foreach ($paths as $path) {

                $this->fileSystemService->removeFile($path);

            }
        } else {
            $this->fileSystemService->removeFile($paths);

        }

    }

}
