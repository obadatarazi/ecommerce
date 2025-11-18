<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\CustomFormRequest;

class UserRequest extends CustomFormRequest
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
                    'full_name' => 'required|max:100',
                    'email' => 'required|email|unique:users',
                    'phone_number' => 'required|min:10',
                    'password' => 'confirmed|min:6',
                    'avatar' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:2048000',
                    'gender' => 'nullable|string|in:MALE,FEMALE',
                    'date_of_birth' => 'nullable|date_format:Y-m-d',
                    'roles.*' => 'required|exists:roles,id',
                ];
            case 'PUT':
            case 'PATCH':
                $user = $this->route('user');
                return [
                    'full_name' => 'max:100',
                    'email' => 'email|unique:users,email,' . $user->id,
                    'phone_number' => 'min:10|unique:users,phone_number,' . $user->id,
                    'password' => 'nullable|confirmed|min:6',
                    'gender' => 'nullable|string|in:MALE,FEMALE',
                    'avatar' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:2048000',
                    'date_of_birth' => 'nullable|date_format:Y-m-d',
                    'roles.*' => 'nullable|exists:roles,id',
                ];
            default:
                break;
        }
        return [];
    }
}
