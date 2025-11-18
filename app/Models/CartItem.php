<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class CartItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'cart_id','product_id','quantity','price','item_total'

    ];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class,'cart_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public static function booted()
    {
        static::saving(function ($item) {
            $item->item_total = $item->price * $item->quantity;
        });
    }
}
