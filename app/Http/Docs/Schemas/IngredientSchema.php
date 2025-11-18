<?php

namespace App\Http\Docs\Schemas;

use Attribute;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Ingredient',
    description: 'Ingredient schema',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'name', type: 'string', example: 'Granola'),
        new OA\Property(property: 'note', type: 'text', example: 'its the best Granola'),
        new OA\Property(property: 'publish', type: 'boolean', example: true),
        new OA\Property(property: 'createdAt', type: 'datetime', example: '2024-07-12 15:20:32'),
        new OA\Property(property: 'updatedAt', type: 'datetime', example: '2024-07-14 15:21:32'),
        new OA\Property(property: 'deleted_at', type: 'datetime', example: '2024-07-15 15:22:32'),
    ],
    type: 'object'
)]
#[Attribute(Attribute::TARGET_CLASS)]
class IngredientSchema
{
    public function __construct()
    {}
}

