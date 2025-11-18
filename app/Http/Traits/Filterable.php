<?php

namespace App\Http\Traits;

use App\Http\QueryFilter\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    /**
     * @param $query
     * @param QueryFilter $filter
     * @return Builder|mixed|void
     */
    public function scopeFilter($query, QueryFilter $filter)
    {
        $query = $filter->applyFilter($query, $this->filterable);
        return $filter->applySort($query, $this->sorterable);
    }
}
