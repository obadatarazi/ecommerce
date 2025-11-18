<?php

namespace App\Http\Controllers\Api\Admin;

use App\Constant\PermissionType;
use App\Http\Controllers\Api\ApiController;
use App\Http\QueryFilter\CartFilter;
use App\Http\Requests\Admin\CartRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class AdminCartController extends ApiController
{
    public function __construct(protected CartService $cartService)
    {
        $this->permissionPrefix = PermissionType::PermissionManageCart->getSection();
        $this->resource = CartResource::class;
        $this->service = $cartService;
        parent::__construct();
    }

    #[OA\Get(
        path: '/api/admin/carts',
        description: 'Get all carts',
        summary: 'List carts',
        security: [['Bearer' => []]],
        tags: ['Admin Cart'],
       )]
    #[OA\Parameter(ref: "#/components/parameters/x-locale")]
    #[OA\Parameter(ref: "#/components/parameters/direction")]
    #[OA\Parameter(ref: "#/components/parameters/page")]
    #[OA\Parameter(ref: "#/components/parameters/limit")]
    #[OA\Parameter(
        name: 'active',
        description: 'Apply filter by active status.',
        in: 'query',
        required: false,
        schema: new OA\Schema(type: 'boolean')
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'Apply filter by id.',
        in: 'query',
        required: false,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Parameter(
        name: 'uuid',
        description: 'Apply filter by uuid.',
        in: 'query',
        required: false,
        schema: new OA\Schema(type: 'integer')
    )]

    #[OA\Response(
        response: 200,
        description: 'Returns all carts',
        content: new OA\MediaType(
            mediaType: 'multipart/form-data',
            schema: new OA\Schema(
                properties: [
                    new OA\Property(
                        property: 'data',
                        type: 'array',
                        items: new OA\Items(ref: '#/components/schemas/Cart')
                    ),
                ]
            )
        )
    )]
    public function index(CartFilter $cartFilter): JsonResponse
    {
        return parent::baseIndex($cartFilter);
    }

    #[OA\Get(
        path: '/api/admin/carts/{cart}',
        description: 'Get one cart by ID',
        summary: 'Get cart details',
        security: [['Bearer' => []]],
        tags: ['Admin Cart'],

    )]
    #[OA\Parameter(
        name: 'cart',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer'),
        description: 'Cart ID'
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
    public function show(Cart $cart): JsonResponse
    {
        return parent::baseShow($cart);
    }

    #[OA\Put(
        path: '/api/admin/carts/{cart}',
        description: 'Update cart by ID',
        summary: 'Update cart',
        security: [['Bearer' => []]],
        tags: ['Admin Cart'],
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
        path: '/api/admin/carts/{cart}',
        description: 'Delete cart by ID',
        summary: 'Delete cart',
        security: [['Bearer' => []]],
        tags: ['Admin Cart']
    )]
    #[OA\Parameter(
        name: 'cart',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer'),
        description: 'Cart ID'
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns deleted cart'
    )]
    #[OA\Response(
        response: 404,
        description: 'Cart not found'
    )]
    public function destroy(Cart $cart): JsonResponse
    {

        return parent::baseDestroy($cart);
    }
}
