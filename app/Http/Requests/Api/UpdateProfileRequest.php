<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\TranslationFormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdateProfileRequest extends TranslationFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [];
        if ($this->method() === 'PUT' || $this->method() === 'PATCH') {
            $rules = [
                'full_name' => ['nullable', 'max:255'],
                'gender' => ['nullable', 'string', 'in:MALE,FEMALE'],
                'date_of_birth' => ['nullable', 'date_format:Y-m-d'],
                'phone_number' => ['nullable','min:10'],
                'avatar' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif' ,'max:2048000'],
                'email' => ['nullable', 'email'],
            ];
        }

        return parent::customRules($rules);
    }
}
