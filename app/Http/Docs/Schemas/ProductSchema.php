<?php

namespace App\Http\Docs\Schemas;

use Attribute;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Product',
    description: 'Detailed Product schema including category, brand, pricing, stock, and expiry information.',
    type: 'object',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 3),
        new OA\Property(property: 'name', type: 'string', example: 'Toyota Engine'),
        new OA\Property(property: 'description', type: 'string', example: 'Genuine engine part'),
        new OA\Property(property: 'type', type: 'string', enum: ['GRANOLA', 'GRANOLA_BARS', 'PENNUT_BUTTER'], example: 'GRANOLA'),
        new OA\Property(property: 'publish', type: 'boolean', example: true),
        new OA\Property(property: 'imge', type: 'string', nullable: true, example: null),
        // Category
        new OA\Property(
            property: 'category',
            type: 'object',
            properties: [
                new OA\Property(property: 'id', type: 'integer', example: 3),
                new OA\Property(property: 'name', type: 'string', example: 'Granola'),
                new OA\Property(property: 'description', type: 'string', example: 'its the best Granola'),
                new OA\Property(property: 'publish', type: 'boolean', example: false),
            ]
        ),
        // Brand
        new OA\Property(
            property: 'brand',
            type: 'object',
            properties: [
                new OA\Property(property: 'id', type: 'integer', example: 1),
                new OA\Property(property: 'name', type: 'string', example: 'Default Brand'),
                new OA\Property(property: 'description', type: 'string', example: 'Default Brand Description'),
                new OA\Property(property: 'shortDescription', type: 'string', example: 'Short Default Brand Description'),
                new OA\Property(property: 'publish', type: 'boolean', example: true),
            ]
        ),
        // Price
        new OA\Property(
            property: 'price',
            type: 'object',
            properties: [
                new OA\Property(property: 'normalPrice', type: 'number', example: '2500.00'),
                new OA\Property(property: 'discountRate', type: 'string', example: '10%'),
                new OA\Property(property: 'discountValue', type: 'number', format: 'float', example: 250),
                new OA\Property(property: 'finalPrice', type: 'number', format: 'float', example: 2250),
            ]
        ),
        // Stock
        new OA\Property(
            property: 'stock',
            type: 'object',
            properties: [
                new OA\Property(property: 'stockStatus', type: 'string', example: '2 Items Left'),
                new OA\Property(property: 'stock', type: 'integer', example: 2),
            ]
        ),
        // Expiry Status
        new OA\Property(
            property: 'expiryStatus',
            type: 'object',
            properties: [
                new OA\Property(property: 'expiryStatus', type: 'string', example: 'Item expired 1 year ago'),
                new OA\Property(property: 'expiryDate', type: 'string', format: 'date', example: '2024-07-15'),
            ]
        ),
        new OA\Property(property: 'productionDate', type: 'string', format: 'date-time', example: '2024-07-15 15:22:32'),
        new OA\Property(property: 'createdAt', type: 'string', format: 'date-time', example: '2025-10-16T15:09:02.000000Z'),
        new OA\Property(property: 'updatedAt', type: 'string', format: 'date-time', example: '2025-10-16T15:09:02.000000Z'),
        new OA\Property(property: 'deleteAt', type: 'string', format: 'date-time', nullable: true, example: null),
    ]
)]
#[Attribute(Attribute::TARGET_CLASS)]
class ProductSchema
{
    public function __construct()
    {}
}
