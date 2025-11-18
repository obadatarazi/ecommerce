<?php

namespace App\Http\QueryFilter;
use Illuminate\Http\Request;

class ProductFilter extends QueryFilter
{
    protected $searchColumns = ['name'];
    public function inStock($value)
    {
    if ($value == 1) {
        $this->query->where('stock', '>', 0);
    } elseif ($value == 0) {
        $this->query->where('stock', '=', 0);
    }

    return $this->query;
    }

    public function haveReviews ($value){
        if (($value == 1)) {
        $this->query->has('reviews');
        }
        elseif ($value == 0) {
        $this->query->doesntHave('reviews');
        }

    return $this->query;
    }
    public function haveMaxStars($value)
    {
    if ($value == 1){
   $this->query->withAvg('reviews', 'stars')->orderBy('reviews_avg_stars', 'DESC');
    }
    return $this->query;
    }
    public function expired($value)
    {
    $now = now();

    if ($value == 1) {
        $this->query->where('expiration_date', '<', $now);
    } elseif ($value == 0) {
       $this->query->where('expiration_date', '>', $now);
    }

    return $this->query;
    }


    public function priceMin($value)
    {
        $this->query->where('price', '>=', $value);
    }

    public function priceMax($value)
    {
        $this->query->where('price', '<=', $value);
    }
    public function materials($value)
    {
        return $this->query->whereHas('ingredient', function ($query) use ($value) {
            $query->where('id', '=', $value);

            }
        );
    }
    public function __construct(Request $request)
    {
        $this->validationArray = [
            'search' => 'string|nullable',
            'publish' => 'boolean',
            'categoryId'=>'integer',
            'brandId' => 'integer',
            'type' =>'string',
            'instock' => 'integer',
            'expired' => 'integer',
            'priceMin' => 'integer',
            'priceMax' => 'integer',
            'ingredient' => 'integer',

        ];

        parent::__construct($request);
    }


}

