<?php

namespace App\Http\QueryFilter;

use Illuminate\Http\Request;

class CurrencyFilter extends QueryFilter
{
    protected $searchColumns = ['name'];
    public function __construct(Request $request)
    {
        $this->validationArray = [
            'search' => 'string|nullable',
            'publish' => 'boolean',
            'symbol' => 'string'
        ];

        parent::__construct($request);
    }

}

