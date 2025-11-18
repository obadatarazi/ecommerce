<?php

namespace App\Http\Docs\Schemas;

use Attribute;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'User',
    description: 'User schema',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'fullName', type: 'string', example: 'John Doe'),
        new OA\Property(property: 'email', type: 'string', example: 'john.doe@example.com'),
        new OA\Property(property: 'phoneNumber', type: 'string', example: '0933578415'),
        new OA\Property(property: 'gender', type: 'string', example: 'MALE'),
        new OA\Property(property: 'dateOfBirth', type: 'datetime', example: '2024-01-01'),
        new OA\Property(property: 'createdAt', type: 'datetime', example: '2024-07-14 15:19:32'),
        new OA\Property(property: 'updatedAt', type: 'datetime', example: '2024-07-14 15:19:32'),
    ],
    type: 'object'
)]
#[Attribute(Attribute::TARGET_CLASS)]
class UserSchema
{
    public function __construct()
    {}
}
