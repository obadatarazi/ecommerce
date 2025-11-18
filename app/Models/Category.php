<?php

namespace App\Models;

use App\Http\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, Filterable, SoftDeletes;

protected $fillable = ['name', 'description','publish'];
protected $filterable = [
'name' => 'like',
'publish' => '=',
];
protected $sorterable = ['id', 'name', 'created_at'];

protected $casts = [
        'publish' => 'boolean',
    ];
    protected $attributes = [
    'publish' => false,
];

}
