<?php

namespace App\Http\Controllers\Api\Admin;

use App\Constant\PermissionType;
use App\Constant\SerializedGroup;
use App\Http\Controllers\Api\ApiController;
use App\Http\QueryFilter\VisualSettingFilter;
use App\Http\Requests\Admin\VisualSettingRequest;
use App\Http\Resources\VisualSettingResource;
use App\Models\VisualSetting;
use App\Services\VisualSettingService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class AdminVisualSettingController extends ApiController
{
    public function __construct(protected VisualSettingService $visualSettingService)
    {
        $this->permissionPrefix = PermissionType::PermissionManageVisualSetting->getSection();
        $this->resource = VisualSettingResource::class;
        $this->service = $visualSettingService;
        parent::__construct();
    }

    #[OA\Get(
        path: '/api/admin/visual-settings',
        description: 'get list visual setting',
        summary: 'get all visual setting',
        security: [['Bearer' => []]],
        tags: ['Admin Visual Setting'],
    )]
    #[OA\Parameter(ref: "#/components/parameters/x-locale")]
    #[OA\Parameter(ref: "#/components/parameters/direction")]
    #[OA\Parameter(ref: "#/components/parameters/page")]
    #[OA\Parameter(ref: "#/components/parameters/limit")]
    #[OA\Parameter(
        name: 'sort',
        description: 'Specify sorting order.',
        in: 'query',
        required: false,
        schema: new OA\Schema(type: 'string', enum: ['id', 'setting_key', 'created_at']),
        example: 'id'
    )]
    #[OA\Parameter(
        name: 'search',
        description: 'Apply filter by setting key.',
        in: 'query',
        required: false,
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Response(
        response: 200,
        description: 'Return All Visual Settings',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(
                allOf: [
                    new OA\Schema(ref: '#/components/schemas/Pagination'),
                    new OA\Schema(
                        properties: [
                            new OA\Property(
                                property: 'pagination',
                                properties: [
                                    new OA\Property(
                                        property: 'items',
                                        type: 'array',
                                        items: new OA\Items(ref: '#/components/schemas/VisualSetting')
                                    ),
                                ],
                                type: 'object'
                            ),
                        ]
                    ),
                ]
            )
        )
    )]
    public function index(VisualSettingFilter $visualSettingFilter): JsonResponse
    {
        return parent::baseIndex($visualSettingFilter);
    }

    #[OA\Get(
        path: '/api/admin/visual-settings/{settingKey}',
        description: 'Fetches a single visual setting by setting Key',
        summary: 'Get one visual setting by setting Key',
        security: [['Bearer' => []]],
        tags: ['Admin Visual Setting'],
    )]
    #[OA\Parameter(ref: "#/components/parameters/x-locale")]
    #[OA\Parameter(
        name: 'settingKey',
        description: 'the visual setting to retrieve',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'string'),
        example: 'LOGO'
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns Get One Visual Setting',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(
                properties: [
                    new OA\Property(property: 'success', type: 'boolean', example: true),
                    new OA\Property(property: 'data', ref: '#/components/schemas/VisualSetting', type: 'object'),
                ]
            )
        )
    )]
    public function show($settingKey): JsonResponse
    {
        $visualSettingKey = $this->visualSettingService->findBySettingKey($settingKey);

        return $this
            ->setResourceClass(VisualSettingResource::class)
            ->setSerializedGroup(SerializedGroup::Details->value)
            ->successResponse($visualSettingKey);
    }

    #[OA\Post(
        path: '/api/admin/visual-settings/{visual_setting}',
        description: 'Update one visual setting',
        summary: 'Update visual setting by ID',
        security: [['Bearer' => []]],
        tags: ['Admin Visual Setting'],
    )]
    #[OA\Parameter(ref: "#/components/parameters/x-locale")]
    #[OA\Parameter(
        name: 'visual_setting',
        description: 'the visual setting to update',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer'),
        example: 1
    )]
    #[OA\RequestBody(
        content: new OA\MediaType(
            mediaType: 'multipart/form-data',
            schema: new OA\Schema(
                properties: [
                    new OA\Property(property: '_method', type: 'text', example: 'PUT'),
                    new OA\Property(property: 'image', type: 'file'),
                    new OA\Property(property: 'link', type: 'text', example: 'link visual setting'),
                    new OA\Property(property: 'translations[en][title]', type: 'string', example: 'title'),
                    new OA\Property(property: 'translations[ar][title]', type: 'string', example: 'عنوان'),
                    new OA\Property(property: 'translations[en][description]', type: 'string', example: 'description'),
                    new OA\Property(property: 'translations[ar][description]', type: 'string', example: 'تفاصيل'),
                ]
            )
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns Updated Visual Setting',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(
                properties: [
                    new OA\Property(property: 'success', type: 'boolean', example: true),
                    new OA\Property(property: 'data', ref: '#/components/schemas/VisualSetting', type: 'object'),
                ]
            )
        )
    )]
    public function update(VisualSettingRequest $visualSettingRequest, VisualSetting $visualSetting): JsonResponse
    {
        return parent::baseUpdate($visualSettingRequest, $visualSetting);
    }
}
