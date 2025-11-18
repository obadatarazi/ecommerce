<?php

namespace App\Http\Docs\Schemas;

use Attribute;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Brand',
    description: 'Brand schema',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'name', type: 'string', example: 'Granola'),
        new OA\Property(property: 'description', type: 'text', example: 'its the best Granola description'),
        new OA\Property(property: 'shortDescription', type: 'text', example: 'its the best Granola shortDescription'),
        new OA\Property(property: 'publish', type: 'boolean', example: true),
        new OA\Property(property: 'featured', type: 'boolean', example: false),
        new OA\Property(property: 'createdAt', type: 'datetime', example: '2024-07-12 15:20:32'),
        new OA\Property(property: 'updatedAt', type: 'datetime', example: '2024-07-14 15:21:32'),

    ],
    type: 'object'
)]
#[Attribute(Attribute::TARGET_CLASS)]
class BrandSchema
{
    public function __construct()
    {}
}
