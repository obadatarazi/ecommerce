<?php

namespace App\Http\Docs\Schemas;

use Attribute;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'VisualSetting',
    description: 'VisualSetting schema',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'settingKey', type: 'string', example: 'HOME_QURAN_SERVICE'),
        new OA\Property(property: 'imageFileUrl', type: 'string', example: '/uploads/visualSetting/Jul-2024/terms.png'),
        new OA\Property(property: 'link', type: 'string', example: 'link visual setting'),
        new OA\Property(property: 'title', type: 'string', example: 'title visual setting'),
        new OA\Property(property: 'description', type: 'string', example: 'description visual setting'),
        new OA\Property(property: 'createdAt', type: 'datetime', example: '2024-07-14 15:19:32'),
        new OA\Property(property: 'updatedAt', type: 'datetime', example: '2024-07-14 15:19:32'),
    ],
    type: 'object'
)]
#[Attribute(Attribute::TARGET_CLASS)]
class VisualSettingSchema
{
    public function __construct()
    {}
}
