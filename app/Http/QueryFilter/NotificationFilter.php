<?php

namespace App\Http\QueryFilter;

use Illuminate\Http\Request;

class NotificationFilter extends QueryFilter
{
    protected $searchColumns = ['title'];
    public function __construct(Request $request)
    {
        $this->validationArray = [
            'search' => 'string|nullable',
            'user' => 'integer',
            'read' => 'boolean'
        ];

        parent::__construct($request);
    }

    public function user($value)
    {
        return $this->query->whereHas('users', function ($query) use ($value) {
            $query->where('id', '=', $value);
        });
    }
}
