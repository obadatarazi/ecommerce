<?php

namespace App\Services;

use App\Models\VisualSetting;

class VisualSettingService extends BaseService
{
    const UPLOAD_FOLDER = 'visualSettings';
    public function __construct(UploadFileService $uploadFileService)
    {
        $this->model = VisualSetting::class;
        $this->keyFileMaps = ['image_file_url' => 'image'];
        $this->uploadFileService = $uploadFileService;
        parent::__construct();
    }

    public function findBySettingKey($settingKey): VisualSetting
    {
        return VisualSetting::query()->where('setting_key', $settingKey)->first();
    }
}
