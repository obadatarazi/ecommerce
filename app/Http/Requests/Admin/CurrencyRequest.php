<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\CustomFormRequest;
use App\Http\Rules\BooleanValidationRule;

class  CurrencyRequest extends CustomFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
                return [];
            case 'POST':
                return [
                    'name' => 'required|max:100',
                    'iso' => 'required|string|max:50',
                    'symbol' => 'required|string|max:50',
                    'exhange_rate' => 'required|numeric|min:0',
                    'publish' => 'required',new BooleanValidationRule(),
                ];
            case 'PUT':
            case 'PATCH':
                return [
                    'name' => 'nullable|max:100',
                    'iso' => 'nullable|string|max:50',
                    'symbol' => 'nullable|string|max:50',
                    'exhange_rate' => 'nullable|numeric|min:0',
                    'publish' => ['nullable', new BooleanValidationRule()],

                ];
            default:
                break;
        }
        return [];
    }
}
