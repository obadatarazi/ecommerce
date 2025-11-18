<?php

namespace App\Http\Requests;


abstract class TranslationFormRequest extends CustomFormRequest
{
    public function __construct() {}

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function customRules($rules)
    {
        $allowedLocales = config('translatable.locales');

        $rules['translations'] = function ($attribute, $value, $fail) use ($allowedLocales) {
            foreach ($value as $locale => $translation) {
                if (!in_array($locale, $allowedLocales)) {
                    $fail("The locale '{$locale}' is not supported.");
                }
            }
        };
        return $rules;
    }

    public function validated($key = null, $default = null)
    {
        $validated = parent::validated();

        if (isset($validated['translations'])) {

            foreach ($validated['translations'] as $locale => $attributes) {
                $validated[$locale] = $attributes;
            }

            unset($validated['translations']);
        }

        return $validated;
    }
}
