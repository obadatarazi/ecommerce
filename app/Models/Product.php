<?php

namespace App\Models;
use App\Http\Traits\Filterable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\hasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;


class Product extends Model
{
    use HasFactory, Filterable, SoftDeletes;
protected $fillable = ['name', 'description','category_id','brand_id','imge','type','price','publish','stock','production_date','expiration_date'];
protected $filterable = [
'name' => 'like',
'publish' => '=',
'category_id' => '=',
'brand_id' => '=',
'type' => '=',
'stock' => '='

];
protected $sorterable = ['id', 'name','price', 'stock','expiration_date','created_at'];
protected $attributes = [
    'publish' => false,
];
protected $casts = [
    'created_at' => 'datetime:Y-m-d ',
    'expiration_date' => 'datetime:Y-m-d',
];
public function getPriceWithDiscountAttribute(): array
    {
        $discountPercentage = match($this->type) {
            'GRANOLA' => 0.1,
            'GRANOLA_BARS' => 0.2,
            'PENNUT_BUTTER' => 0.3,
            default => 0
        };
    $discountRate =  $discountPercentage * 100;
    $discountValue = $this->price * $discountPercentage;
    $finalPrice = $this->price - $discountValue;

    return [
        'normalPrice' => $this->price,
        'discountRate' => $discountRate . '%',
        'discountValue' => $discountValue,
        'finalPrice' => $finalPrice,
    ];
    }
    public function getStockStatusAttribute(): array {
        $stockstatus = match(true){
            $this->stock == 0 => 'OUT OF STOCK',
            $this->stock == 1 => 'ONE ITEM LEFT',
            default => $this->stock . ' Items Left'
        };
        return [
            'stockStatus' => $stockstatus,
            'stock' => $this->stock,
        ];
    }
public function getExpiryDateAttribute(): array
{
    Carbon::setLocale('en');
    $now = Carbon::now();
    $expiryDate = Carbon::parse($this->expiration_date);

    $status = match (true) {
        $expiryDate->isFuture() => 'Item valid' ,
        $expiryDate->isPast() => 'Item expired ' . $expiryDate->diffForHumans($now, true) . ' ago',
        default => 'Invalid date',
    };

    return [
        'expiryStatus' => $status,
        'expiryDate' => $expiryDate->toDateString(),
    ];
}

public function getAverageStarAttribute()
{
$averagestar = $this->reviews->avg('stars');
return $averagestar;
}

public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
public function brand(): BelongsTo
{
    return $this->BelongsTo(Brand::class);
}
public function reviews():hasMany
    {
        return $this->hasMany(Review::class);
    }

public function ingredients():BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class,'ingredient_product');
    }

}
