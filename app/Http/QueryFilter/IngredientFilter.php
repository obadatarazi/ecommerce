<?php

namespace App\Http\QueryFilter;

use Illuminate\Http\Request;

class IngredientFilter extends QueryFilter
{
    protected $searchColumns = ['name'];
    public function __construct(Request $request)
    {
        $this->validationArray = [
            'search' => 'string|nullable',
            'publish' => 'boolean',
        ];

        parent::__construct($request);
    }

}

