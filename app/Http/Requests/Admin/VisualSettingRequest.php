<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\TranslationFormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class VisualSettingRequest extends TranslationFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'image' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp|max:2048000',
            'link' => 'nullable|string',
            'translations' => 'nullable|array',
            'translations.*.title' => 'nullable|string|max:255',
            'translations.*.description' => 'nullable|string',
        ];

        return parent::customRules($rules);
    }
}
