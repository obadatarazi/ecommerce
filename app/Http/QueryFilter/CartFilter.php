<?php

namespace App\Http\QueryFilter;

use Illuminate\Http\Request;

class CartFilter extends QueryFilter
{
    public function __construct(Request $request)
    {
        $this->validationArray = [
            'uuid' => 'string',
            'user_id' => 'integer',
            'active' => 'boolean',
        ];

        parent::__construct($request);
    }

}

