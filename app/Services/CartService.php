<?php

namespace App\Services;

use App\Models\Cart;
use App\Services\CartItemService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;


class CartService extends BaseService
{
    private CartItemService $cartItemService;
    private ProductService $productService;


    public function __construct(CartItemService $cartItemService, ProductService $productService)
    {
        $this->model = Cart::class;
        $this->cartItemService = $cartItemService;
        $this->productService = $productService;
        parent::__construct();
    }
    /**
     * new cart
     */
    public function create($data): Cart
    {
        $cart = new Cart($data);
        $cart->fill($data);
        $cart->save();
        return $cart;
    }



    public function createByUser($user): Cart | array
    {
        $seconds = now()->format('s');
        $hour = now()->format('h');
        $day = now()->format('d');
        $month = now()->format('m');
        $year = now()->format('Y');
        $tempId = rand(1000, 9999);
        $uuid = "cart-{$tempId}-{$day}{$month}{$year}-{$hour}{$seconds}";

        $dbCart = Cart::where('user_id', $user->id)->first();
        if ($dbCart) {
            $message = 'you have a cart';
            return [$dbCart, $message];
        } else {
            $cart = new Cart();
            $cart->user_id = $user->id;
            $cart->uuid = $uuid;
            $cart->save();
            $message = 'your cart created';
            return [$cart,$message];
        }
    }

    public function addItems($data,$cartId)
    {
        $cartItems = $data['cart_items'];
        if ($cartItems){
            foreach ($cartItems as $item) {
                $product = $this->productService->getFindById($item['product_id']);
                $price = $product->price;
                $item_total = $price * $item['quantity'];
                $dataItem = ['cart_id'=>$cartId,'product_id'=>$item['product_id'],'quantity'=>$item['quantity'], 'price'=>$price, 'item_total'=>$item_total];
                $this->cartItemService->create($dataItem);
            }

        }
    }


    /**
     * update exist cart
     */
    public function update($data, Cart|Model $cart): Cart
    {
        $cart->update($data);
        $cart->fill($data);
        return $cart;
    }
    public function showByUser($user)
    {
        $dbCart = Cart::where('user_id', $user->id)->where('active',true)->firstOrFail();
        return $dbCart;
    }



    /**
     * update active status
     * */
    public function toggleActive(Cart|Model $cart, bool $status): Cart
    {
        $cart->active = $status;
        $cart->save();
        return $cart;
    }

}

