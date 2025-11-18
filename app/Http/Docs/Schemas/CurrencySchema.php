<?php

namespace App\Http\Docs\Schemas;

use Attribute;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Currency',
    description: 'Currency schema',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'name', type: 'string', example: 'Syrian Arab Republic'),
        new OA\Property(property: 'symbol', type: 'string', example: 'SYP'),
        new OA\Property(property: 'iso', type: 'string', example: 'SYP'),
        new OA\Property(property: 'exhange_rate', type: 'number', format: 'float', example: 11900.0),
        new OA\Property(property: 'publish', type: 'boolean', example: true),
        new OA\Property(property: 'createdAt', type: 'datetime', example: '2024-11-04 11:20:32'),
        new OA\Property(property: 'updatedAt', type: 'datetime', example: '2024-11-04 11:21:32'),
    ],
    type: 'object'
)]
#[Attribute(Attribute::TARGET_CLASS)]
class CurrencySchema
{
    public function __construct()
    {}
}
