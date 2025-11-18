<?php

namespace App\Models;

use App\Http\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory, Filterable;

protected $fillable = ['name', 'iso','symbol','exhange_rate','publish'];
protected $filterable = [
'name' => 'like',
'publish' => '=',
'symbol' => '='
];
protected $sorterable = ['id', 'name','exhange_rate','created_at'];

protected $casts = [
        'publish' => 'boolean',
];
protected $attributes = [
    'publish' => false,
];

}
