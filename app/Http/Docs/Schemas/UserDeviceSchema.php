<?php

namespace App\Http\Docs\Schemas;

use Attribute;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'UserDevice',
    description: 'User Device schema',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'fcmToken', type: 'string', example: 'fcm token device token'),
        new OA\Property(property: 'active', type: 'boolean', example: true),
        new OA\Property(property: 'user', type: 'string', example: 'user full name'),
        new OA\Property(property: 'createdAt', type: 'datetime', example: '2024-07-14 15:19:32'),
        new OA\Property(property: 'updatedAt', type: 'datetime', example: '2024-07-14 15:19:32'),
    ],
    type: 'object'
)]
#[Attribute(Attribute::TARGET_CLASS)]
class UserDeviceSchema
{
    public function __construct()
    {}
}
