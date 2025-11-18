<?php

namespace App\Http\Docs\Schemas;

use Attribute;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Notification',
    description: 'Notification schema',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'metaData', type: 'string', example: 'meta data notification'),
        new OA\Property(property: 'title', type: 'string', example: 'title notification'),
        new OA\Property(property: 'body', type: 'string', example: 'body notification'),
        new OA\Property(property: 'createdAt', type: 'datetime', example: '2024-07-14 15:19:32'),
        new OA\Property(property: 'updatedAt', type: 'datetime', example: '2024-07-14 15:19:32'),
    ],
    type: 'object'
)]
#[Attribute(Attribute::TARGET_CLASS)]
class NotificationSchema
{
    public function __construct()
    {}
}
