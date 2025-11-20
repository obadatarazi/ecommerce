<?php

namespace App\Http\Controllers\Api\User;

use App\Constant\SerializedGroup;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\User\CartRequest;
use App\Http\Resources\CartResource;
use App\Http\QueryFilter\CartFilter;
use App\Models\Cart;
use App\Services\CartService;
use App\Services\CartItemService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class   UserCartController extends ApiController
{
    public function __construct(protected CartService $cartService, protected CartItemService $cartItemService)
    {
        $this->resource = CartResource::class;
        $this->service = $cartService;
        $this->itemservice = $cartItemService;

    }

    #[OA\Post(
        path: '/api/user/carts',
        description: 'Create a new cart',
        summary: 'Create cart',
        security: [['Bearer' => []]],
        tags: ['User Cart'],

    )]

    #[OA\Response(
        response: 201,
        description: 'Returns created cart',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(ref: '#/components/schemas/Cart')
        )
    )]
    public function store(): JsonResponse
    {
        $user = auth()->user();

        list($cart,$message) = $this->cartService->createByUser( $user);

        return $this
            ->setResourceClass(CartResource::class)
            ->setSeriaizedGroup(SerializedGroup::List->value)
            ->successResponse($cart,200,$message);
    }

    #[OA\Post(
    path: '/api/user/carts/items',
    description: 'Add items to the cart',
    summary: 'Add Item to cart',
    security: [['Bearer' => []]],
    tags: ['User Cart'],
)]
#[OA\RequestBody(
    content: new OA\MediaType(
        mediaType: 'application/json',
        schema: new OA\Schema(
            properties: [
                new OA\Property(
                    property: "cartItems",
                    type: "array",
                    items: new OA\Items(
                        type: "object",
                        properties: [
                            new OA\Property(property: "productId", type: "integer", example: 5),
                            new OA\Property(property: "quantity", type: "integer", example: 2),
                        ]
                    )
                )
            ]
        )
    )
)]
#[OA\Response(
    response: 201,
    description: 'Returns cart items',
    content: new OA\MediaType(
        mediaType: 'application/json',
        schema: new OA\Schema(ref: '#/components/schemas/Cart')
    )
)]
public function addItemsToCart(CartRequest $request)
{

    $userId = auth()->id();
    try{
    $cart = $this->service->getFindByColumn('user_id', $userId);
    }
    catch(\Exception $e){
        $user = auth()->user();
        $cart = $this->cartService->createByUser( $user);
    }

    $cartId = $cart->id;
    $this->service->addItems($request->validated(),$cartId);

        return $this
            ->setResourceClass(CartResource::class)
            ->setSerializedGroup(SerializedGroup::List->value)
            ->successResponse($cart);
}


    #[OA\Get(
        path: '/api/user/my/cart/',
        description: 'Get My Cart By userId',
        summary: 'Get My Cart Details',
        security: [['Bearer' => []]],
        tags: ['User Cart'],

    )]
    #[OA\Response(
        response: 200,
        description: 'Returns cart details',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(ref: '#/components/schemas/Cart')
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'Cart not found'
    )]
    public function show(): JsonResponse
    {
        $userId = auth()->user()->id;
        $cart = $this->service->getFindByColumn('user_id', $userId);
         return $this
            ->setResourceClass(CartResource::class)
            ->setSerializedGroup(SerializedGroup::List->value)
            ->successResponse($cart);

    }

   #[OA\Get(
    path: '/api/user/carts/uuid/{uuid}',
    description: 'Get one cart by UUID',
    summary: 'Get cart details',
    security: [['Bearer' => []]],
    tags: ['User Cart']
    )]
    #[OA\Parameter(
    name: 'uuid',
    in: 'path',
    required: true,
    schema: new OA\Schema(type: 'string'),
    description: 'Cart UUID'

    )]
    #[OA\Response(
    response: 200,
    description: 'Returns cart details',
    content: new OA\MediaType(
        mediaType: 'application/json',
        schema: new OA\Schema(ref: '#/components/schemas/Cart')
    )
    )]
    #[OA\Response(
    response: 404,
    description: 'Cart not found'
    )]
    public function showByUuid(string $uuid): JsonResponse
    {

        $cart = $this->service->getFindByColumn('uuid', $uuid);
         return $this
            ->setResourceClass(CartResource::class)
            ->setSerializedGroup(SerializedGroup::List->value)
            ->successResponse($cart);
    }

    #[OA\Put(
        path: '/api/user/carts/{cart}',
        description: 'Update cart by ID',
        summary: 'Update cart',
        security: [['Bearer' => []]],
        tags: ['User Cart'],
        parameters: [new OA\Parameter(ref: "#/components/parameters/x-locale")],

    )]
    #[OA\Parameter(
        name: 'cart',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer'),
        description: 'Cart ID'
    )]
    #[OA\RequestBody(
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(
                properties: [
                    new OA\Property(property: 'active', type: 'boolean', example: true),
                ]
            )
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns updated cart',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(ref: '#/components/schemas/Cart')
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'Cart not found'
    )]
    public function update(CartRequest $request, Cart $cart): JsonResponse
    {
        return parent::baseUpdate($request, $cart);
    }


    #[OA\Delete(
        path: '/api/user/carts/items/',
        description: 'Delete cart items',
        summary: 'Delete one, multiple, or all cart items',
        security: [['Bearer' => []]],
        tags: ['User Cart'],
    )]

    #[OA\RequestBody(
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(
                properties: [
                    new OA\Property(
                        property: 'cartItems',
                        type: 'array',
                        description: 'IDs of items to delete, or [0] to delete all',
                        items: new OA\Items(type: 'integer', example: 5)
                    )
                ]
            )
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Deleted items successfully',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(
                properties: [
                    new OA\Property(property: 'message', type: 'string', example: 'Selected items deleted')
                ]
            )
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'Cart not found'
    )]
    public function destroy(CartRequest $request): JsonResponse
    {
        $userId = auth()->user()->id;
        $cart = $this->service->getFindByColumn('user_id', $userId);
        $cartId=$cart->id;
        $input=$request->validated();
        $result = $this->cartItemService->deleteItems($cartId,$input);
        return response()->json($result);
    }

    }
