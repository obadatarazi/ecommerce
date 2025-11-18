<?php

namespace App\Services;

use App\Models\MultiTypeSetting;

class MultiTypeSettingService extends BaseService
{
    public function __construct()
    {
        $this->model = MultiTypeSetting::class;
        parent::__construct();
    }

    public function findBySettingKey($settingKey): MultiTypeSetting
    {
        return MultiTypeSetting::query()->where('setting_key', $settingKey)->first();
    }
}
