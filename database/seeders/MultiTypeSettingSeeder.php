<?php

namespace Database\Seeders;

use App\Models\MultiTypeSetting;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MultiTypeSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $now = Carbon::now();

        $data = [
            [
                'id' => 1,
                'setting_key' => 'FACEBOOK_LINK',
                'value' => 'https://www.facebook.com',
                'type' => 'LINK',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'setting_key' => 'INSTAGRAM_LINK',
                'value' => 'https://instagram.com',
                'type' => 'LINK',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'setting_key' => 'YOUTUBE_LINK',
                'value' => 'https://youtube.com',
                'type' => 'LINK',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'setting_key' => 'CONTACT_EMAIL',
                'value' => 'test@test.com',
                'type' => 'EMAIL',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'setting_key' => 'CONTACT_HOURS',
                'value' => '3h',
                'type' => 'TEXT',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 6,
                'setting_key' => 'PHONE_NUMBER',
                'value' => '099342938482',
                'type' => 'PHONE_NUMBER',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($data as $value) {
            $multiTypeSetting = new MultiTypeSetting($value);
            $multiTypeSetting->save();
        }
    }
}
