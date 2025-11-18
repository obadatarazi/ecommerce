<?php

namespace App\Models;
use App\Http\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Review extends Model
{
    use HasFactory, Filterable;

    protected $fillable = ['user_id','product_id','stars','comment','publish'];

    protected $filterable = [
        'user_id' => '=',
        'product_id' => '=',
        'stars' => '=',
        'publish' => '=',
    ];
    protected $sorterable = [ 'id','stars', 'publish','created_at' ];
protected $attributes = [
    'stars' => 0.0,
];
public function user(): BelongsTo
{
    return $this->BelongsTo(User::class);
}
public function product() :BelongsTo
{
    return $this->BelongsTo(Product::class);
}

}
