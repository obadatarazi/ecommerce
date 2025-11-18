<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\CustomFormRequest;

class ProductRequest extends CustomFormRequest
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
                    'name' => 'required|string|max:100',
                    'description' => 'nullable|string',
                    'imge' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:2048000',
                    'type' => 'required|string|in:GRANOLA,GRANOLA_BARS,PENNUT_BUTTER',
                    'category_id' => 'required|integer|exists:categories,id',
                    'brand_id' => 'nullable|integer|exists:brands,id',
                    'price' => 'required|numeric|min:0',
                    'stock' => 'required|numeric|min:0',
                    'production_date' => 'required|date',
                    'expiration_date' => 'required|date',
                    'publish' => 'nullable|boolean',
                    'ingredients' => ['nullable', 'array'],
                    'ingredients.*' => ['nullable', 'integer', 'exists:ingredient,id'],

                ];

            case 'PUT':
            case 'PATCH':
                $product = $this->route('product');
                return [
                    'name' => 'nullable|string|max:100',
                    'description' => 'nullable|string',
                    'imge' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:2048000',
                    'type' => 'nullable|string|in:GRANOLA,GRANOLA_BARS,PENNUT_BUTTER',
                    'category_id' => 'nullable|integer|exists:categories,id',
                    'brand_id' => 'nullable|integer|exists:brands,id',
                    'price' => 'nullable|numeric|min:0',
                    'stock' => 'nullable|numeric|min:0',
                    'production_date' => 'nullable|date',
                    'expiration_date' => 'nullable|date',
                    'publish' => 'nullable|boolean',
                    'ingredients' => ['nullable', 'array'],
                    'ingredients.*' => ['nullable', 'integer', 'exists:ingredient,id'],
                ];

            default:
                break;
        }

        return [];
    }
}
