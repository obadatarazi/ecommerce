<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\CustomFormRequest;

class IngredientRequest extends CustomFormRequest
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
                    'note' => 'nullable|string',
                    'publish' => 'nullable|boolean',

                ];
            case 'PUT':
            case 'PATCH':
                return [
                    'name' => 'nullable|max:100',
                    'note' => 'nullable|string',
                    'publish' => 'nullable|boolean',
                ];
            default:
                break;
        }
        return [];
    }
}
