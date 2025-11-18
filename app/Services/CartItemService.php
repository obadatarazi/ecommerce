<?php

namespace App\Services;

use App\Models\CartItem;


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

public function deleteItems($cartId, array $input)
{
    
    if (in_array(0, $input, true)) {
        CartItem::where('cart_id', $cartId)->delete();
        return ['message' => 'All items deleted'];
    }

    foreach ($input as $id) {
        CartItem::where('cart_id', $cartId)
            ->where('id', $id)
            ->delete();
    }
    return ['message' => 'Selected items deleted'];
}






}

