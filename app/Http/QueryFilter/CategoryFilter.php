<?php

namespace App\Http\QueryFilter;

use Illuminate\Http\Request;

class CategoryFilter extends QueryFilter
{
    protected $searchColumns = ['name'];
    public function __construct(Request $request)
    {
        $this->validationArray = [
            'search' => 'string|nullable',
            'publish' => 'boolean',
            'featured' => 'boolean'
        ];

        parent::__construct($request);
    }

}

