<?php

namespace App\Http\Docs\Schemas;

use Attribute;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Review',
    description: 'Review schema',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'userId', type: 'integer', example: 1),
        new OA\Property(property: 'ProductId', type: 'integer', example: 2),
        new OA\Property(property: 'comment', type: 'text', example: 'This is amazing'),
        new OA\Property(property: 'stars', type: 'integer', example: 2.5),
        new OA\Property(property: 'publish', type: 'boolean', example: true),
        new OA\Property(property: 'createdAt', type: 'datetime', example: '2024-07-12 15:20:32'),
        new OA\Property(property: 'updatedAt', type: 'datetime', example: '2024-07-14 15:21:32'),
        new OA\Property(property: 'deletedAt', type: 'datetime', example: '2024-07-15 15:22:32'),

    ],
    type: 'object'
)]
#[Attribute(Attribute::TARGET_CLASS)]
class ReviewSchema
{
    public function __construct()
    {}
}
