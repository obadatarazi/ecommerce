<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\Filterable;

class brand extends Model
{
    use HasFactory, Filterable;
protected $fillable = ['name', 'description','short_description','publish','featured'];
protected $filterable = [
'name' => 'like',
'publish' => '=',
'featured' => '=',
];
protected $sorterable = ['id', 'name','created_at'];
protected $casts = [
        'featured' => 'boolean',
        'publish' => 'boolean',
    ];
protected $attributes = [
    'publish' => false,
    'featured'=> false
];

}
