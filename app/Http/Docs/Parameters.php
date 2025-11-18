<?php

namespace App\Http\Docs;

use Attribute;
use OpenApi\Attributes as OA;

#[OA\Parameter(
    name: 'direction',
    description: 'Specify sorting order.',
    in: 'query',
    required: false,
    schema: new OA\Schema(type: 'string', enum: ['asc', 'desc']),
    example: 'asc'
)]

#[OA\Parameter(
    name: 'page',
    description: 'Determine page number.',
    in: 'query',
    required: false,
    schema: new OA\Schema(type: 'integer'),
    example: 1
)]
#[OA\Parameter(
    name: 'limit',
    description: 'Determine number of items per page.',
    in: 'query',
    required: false,
    schema: new OA\Schema(type: 'integer', enum: [10, 20, 30, 40]),
    example: 10
)]
#[OA\Parameter(
    name: 'x-locale',
    in: 'header',
    required: false,
    schema: new OA\Schema(type: 'string', enum: ['en', 'ar']),
    example: 'en'
)]
#[Attribute(Attribute::TARGET_CLASS)]
class Parameters
{
    public function __construct()
    {}
}
