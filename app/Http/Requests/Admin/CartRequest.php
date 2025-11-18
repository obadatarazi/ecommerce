<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\CustomFormRequest;
use App\Http\Rules\BooleanValidationRule;


class CartRequest extends CustomFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        switch ($this->method()) {

            case 'PUT':
            case 'PATCH':
                return [
                    'active' => 'nullable',new BooleanValidationRule(),
                    ];
            default:
                break;
        }
        return [];
    }
}
