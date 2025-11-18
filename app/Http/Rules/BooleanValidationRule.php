<?php

namespace App\Http\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class BooleanValidationRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!in_array($value, [true, false, 1, 0, '1', '0'], true)) {
            $fail($this->message());
        }
    }

    public function message(): string
    {
        return ':attribute must be true or false.';
    }
}
