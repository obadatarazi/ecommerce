<?php

namespace App\Http\Docs\Schemas;

use Attribute;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Cart',
    description: 'Cart schema',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'uuid', type: 'string', example: 'cart-8765-01022025-1512'),
        new OA\Property(
            property: 'user',
            properties: [
                new OA\Property(property: 'userId', type: 'integer', example: 1),
                new OA\Property(property: 'userFullName', type: 'string', example: 'obada'),],),
        new OA\Property(
            property: 'items',
            properties: [
                new OA\Property(property: 'id', type: 'integer', example: 1),
                new OA\Property(property: 'productName', type: 'string', example: 'Granola'),
                new OA\Property(property: 'price', type: 'integer', example: 200),
                new OA\Property(property: 'quantity', type: 'integer', example: 2),
                new OA\Property(property: 'itemTotla', type: 'integer', example: 400),
    ],),

        new OA\Property(property: 'active', type: 'boolean', example: true),
        new OA\Property(property: 'subtotal', type: 'number', example: 123.2),
        new OA\Property(property: 'discount', type: 'number', example: 10),
        new OA\Property(property: 'total', type: 'number', example: 113.2),
        new OA\Property(property: 'createdAt', type: 'datetime', example: '2024-08-12 15:20:32'),
        new OA\Property(property: 'updatedAt', type: 'datetime', example: '2024-10-14 15:21:32'),

    ],
    type: 'object'
)]
#[Attribute(Attribute::TARGET_CLASS)]
class CartSchema
{
    public function __construct()
    {}
}
