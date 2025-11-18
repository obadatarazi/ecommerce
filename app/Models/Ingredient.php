<?php

namespace App\Models;

use App\Http\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ingredient extends Model
{
    use HasFactory,Filterable;

    protected $fillable = ['name', 'note','publish'];

    protected $filterable = [
        'name' => 'like',
        'publish' => '=',


    ];

    protected $sorterable = ['id', 'createAt'];
    protected $casts = [
        'publish' => 'boolean',
    ];
    protected $attributes = [
    'publish' => false,
];

public function products():BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }


}
