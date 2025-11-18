<?php

namespace App\Http\QueryFilter;

use Illuminate\Http\Request;

class VisualSettingFilter extends QueryFilter
{
    protected $searchColumns = ['setting_key'];
    public function __construct(Request $request)
    {
        $this->validationArray = [
            'search' => 'string|nullable',
        ];

        parent::__construct($request);
    }
}
