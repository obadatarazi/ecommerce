<?php

namespace App\Http\Requests\User;

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
            case 'POST':
                return [
                    'cart_items' => ['required', 'array'],
                    'cart_items.*.product_id' => ['required', 'integer', 'exists:products,id'],
                    'cart_items.*.quantity' => ['nullable', 'integer', 'min:1'],
                    'active' => 'nullable',new BooleanValidationRule(),
                    ];

            case 'PUT':
            case 'DELETE':
            return [
                'cart_items' => ['required', 'array'],
                'cart_items.*' => ['required', 'integer'],
            ];
            case 'PATCH':
                return [
                    'cart_items' => ['nullable', 'array'],
                    'cart_items.*.product_id' => ['nullable', 'integer', 'exists:products,id'],
                    'cart_items.*.quantity' => ['nullable', 'integer', 'min:0'],
                    'active' => 'nullable',new BooleanValidationRule(),
                    ];
            default:
                break;
        }
        return [];
    }
}
