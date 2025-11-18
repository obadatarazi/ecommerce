<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CustomFormRequest extends FormRequest
{

    protected function prepareForValidation(): void
    {
        if ($this->has('publish')) {
            $this->merge([
                'publish' => filter_var($this->publish, FILTER_VALIDATE_BOOLEAN),
            ]);
        }
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);
        return $this->convertKeysToSnakeCase($data);
    }

    private function convertKeysToSnakeCase($data)
    {
        $snakeCaseData = [];

        foreach ($data as $key => $value) {
            $snakeCaseKey = Str::snake($key);

            if (is_array($value)) {
                $snakeCaseData[$snakeCaseKey] = $this->convertKeysToSnakeCase($value);
            } else {
                $snakeCaseData[$snakeCaseKey] = $value;
            }
        }

        return $snakeCaseData;
    }

}
