<?php

namespace App\Models;

use App\Http\Docs\Schemas\MultiTypeSettingSchema;
use App\Http\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[MultiTypeSettingSchema]
class MultiTypeSetting extends BaseModel
{
    use HasFactory, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['value', 'type', 'description'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = ['created_at' => 'datetime:Y-m-d H:i:s'];

    protected $filterable = [
        'setting_key' => 'like',
        'type' => '='
    ];

    protected $sorterable = ['id', 'setting_key', 'type', 'created_at'];

    protected $appends = ['type_value'];

    public function getTypeValueAttribute()
    {
        return match ($this->attributes['type']) {
            'EMAIL' => __('enum.EMAIL'),
            'LINK' => __('enum.LINK'),
            'NUMBER' => __('enum.NUMBER'),
            'PHONE_NUMBER' => __('enum.PHONE_NUMBER'),
            'TEXT' => __('enum.TEXT'),
            default => $this->attributes['type'],
        };
    }

    public function getCustomTypeAttribute(): array
    {
        return [
            'label' => $this->getTypeValueAttribute(),
            'value' => $this->attributes['type'],
        ];
    }
}
