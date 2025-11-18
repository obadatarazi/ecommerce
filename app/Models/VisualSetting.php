<?php

namespace App\Models;

use App\Http\Docs\Schemas\VisualSettingSchema;
use App\Http\Traits\Filterable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[VisualSettingSchema]
class VisualSetting extends BaseModel implements TranslatableContract
{
    use HasFactory, Translatable, Filterable;

    protected $fillable = ['image_file_url', 'link'];
    public $translatedAttributes = ['title', 'description'];

    protected $casts = ['created_at' => 'datetime:Y-m-d H:i:s'];

    protected $filterable = ['setting_key' => 'like'];

    protected $sorterable = ['id', 'setting_key', 'created_at'];

}
