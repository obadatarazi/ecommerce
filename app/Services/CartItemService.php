<?php

namespace App\Services;

use App\Models\CartItem;
use Illuminate\Support\Arr;



class CartItemService extends BaseService
{

    public function __construct()
    {
        $this->model = CartItem::class;
        parent::__construct();
    }
    /**
     * new cartItem
     */
    public function create($data): CartItem
    {
        $cartItem = new CartItem($data);

        $cartItem->fill($data);
        $cartItem->save();
        return $cartItem;
    }


public function deleteItems($cartId, array $ids)
{
    // تحويل كل العناصر لأرقام
    $ids = Arr::flatten($ids);

    // حالة حذف كل شيء
    if ($ids === [0]) {
        CartItem::where('cart_id', $cartId)->delete();
        return ['message' => 'All items deleted'];
    }

    // جلب الموجود فعلياً من الـ IDs
    $existing = CartItem::where('cart_id', $cartId)
        ->whereIn('id', $ids)
        ->pluck('id')
        ->toArray();

    // تحديد المفقود
    $missing = array_diff($ids, $existing);

    // لو في مفقود → لا نحذف شيء
    if (!empty($missing)) {
        return [
            'success' => false,
            'message' => 'Some items not found in your cart',
            'missing_ids' => array_values($missing)
        ];
    }

    // كل شيء موجود → نحذف
    CartItem::where('cart_id', $cartId)
        ->whereIn('id', $ids)
        ->delete();

    return ['message' => 'Selected items deleted'];
}








}

