<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\CustomFormRequest;

class ReviewRequest extends CustomFormRequest
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
                    'user_id' => 'required|integer|exists:users,id',
                    'product_id' => 'required|integer|exists:products,id',
                    'comment' => 'nullable|string',
                    'stars' => 'nullable|numeric|min:1|max:5',
                    'publish' => 'nullable|boolean',
                ];

            case 'PUT':
            case 'PATCH':
                return [
                    'comment' => 'nullable|string',
                    'publish' => 'nullable|boolean',
                    'stars' => 'nullable|numeric|min:1|max:5',
                ];

            default:
                return [];
        }
    }
}
