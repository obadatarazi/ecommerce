<?php

namespace App\Http\QueryFilter;

use Illuminate\Http\Request;

class ReviewFilter extends QueryFilter
{
    public function __construct(Request $request)
    {
        $this->validationArray = [
            'userId' => 'integer',
            'ProductId' => 'integer',
            'stars' => 'integer',
            'publish' => 'boolean',
        ];

        parent::__construct($request);
    }

}

