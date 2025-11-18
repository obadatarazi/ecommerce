<?php

namespace App\Models;

use App\Http\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory, Filterable;

protected $fillable = ['user_id', 'active','uuid','total','subtotal','discount'];
protected $filterable = [
'user_id' => '=',
'active' => '=',
'uuid' => '=',
];
protected $sorterable = ['id', 'user_id', 'created_at'];

protected $casts = [
        'active' => 'boolean',
    ];

    protected $attributes = [
    'active' => true,
    'total' => 0.0,
    'subtotal' => 0.0 ,
    'discount' => 0.0,
];

public function user(): belongsTo
{
    return $this->BelongsTo(User::class,'user_id');
}

  public function items():HasMany

    {
        return $this->hasMany(CartItem::class);
    }

}
