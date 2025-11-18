<?php

namespace Database\Seeders;

use App\Models\VisualSetting;
use App\Models\VisualSettingTranslation;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class VisualSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $visualData = [
            [
                'id' => 1,
                'setting_key' => 'ABOUT_US_PAGE'
            ],
            [
                'id' => 2,
                'setting_key' => 'TERMS_PAGE'
            ],
            [
                'id' => 3,
                'setting_key' => 'PRIVACY_PAGE'
            ],
            [
                'id' => 4,
                'setting_key' => 'LOGO'
            ],
        ];

        foreach ($visualData as $visual) {
            $visualSetting = new VisualSetting($visual);
            $visualSetting->save();
        }

        $visualTranslationsData = [
            [
                'id' => 1,
                'visual_setting_id' => 1,
                'locale' => 'ar',
                'title' => 'عنوان صفحة عنا'
            ],
            [
                'id' => 2,
                'visual_setting_id' => 1,
                'locale' => 'en',
                'title' => 'title about us page'
            ],
            [
                'id' => 3,
                'visual_setting_id' => 2,
                'locale' => 'ar',
                'title' => 'عنوان صفحة الشروط'
            ],
            [
                'id' => 4,
                'visual_setting_id' => 2,
                'locale' => 'en',
                'title' => 'title terms page'
            ],
            [
                'id' => 5,
                'visual_setting_id' => 3,
                'locale' => 'ar',
                'title' => 'عنوان صفحة الخصوصية'
            ],
            [
                'id' => 6,
                'visual_setting_id' => 3,
                'locale' => 'en',
                'title' => 'title privacy policy'
            ],
            [
                'id' => 7,
                'visual_setting_id' => 4,
                'locale' => 'ar',
                'title' => 'لوغو منصة'
            ],
            [
                'id' => 8,
                'visual_setting_id' => 4,
                'locale' => 'en',
                'title' => 'logo'
            ],
        ];

        foreach ($visualTranslationsData as $visualTranslation) {
            $visualSettingTranslation = new VisualSettingTranslation($visualTranslation);
            $visualSettingTranslation->save();
        }
    }
}
