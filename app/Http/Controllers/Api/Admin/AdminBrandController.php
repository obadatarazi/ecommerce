<?php

namespace App\Http\Controllers\Api\Admin;

use App\Constant\PermissionType;
use App\Http\Controllers\Api\ApiController;
use App\Http\QueryFilter\BrandFilter;
use App\Http\Requests\Admin\BrandRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use App\Services\BrandService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class AdminBrandController extends ApiController
{
    public function __construct(protected BrandService $brandService)
    {
        $this->permissionPrefix = PermissionType::PermissionManageBrand->getSection();
        $this->resource = BrandResource::class;
        $this->service = $brandService;
        parent::__construct();
    }

    #[OA\Get(
        path: '/api/admin/brands',
        description: 'Get all brands',
        summary: 'List brands',
        security: [['Bearer' => []]],
        tags: ['Admin Brand'],
       )]
    #[OA\Parameter(ref: "#/components/parameters/x-locale")]
    #[OA\Parameter(ref: "#/components/parameters/direction")]
    #[OA\Parameter(ref: "#/components/parameters/page")]
    #[OA\Parameter(ref: "#/components/parameters/limit")]
    #[OA\Parameter(
        name: 'search',
        description: 'Apply filter by brand name.',
        in: 'query',
        required: false,
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'publish',
        description: 'Apply filter by publish status.',
        in: 'query',
        required: false,
        schema: new OA\Schema(type: 'boolean')
    )]
        #[OA\Parameter(
        name: 'featured',
        description: 'Apply filter by featured status.',
        in: 'query',
        required: false,
        schema: new OA\Schema(type: 'boolean')
    )]

    #[OA\Response(
        response: 200,
        description: 'Returns all brands',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(
                properties: [
                    new OA\Property(
                        property: 'data',
                        type: 'array',
                        items: new OA\Items(ref: '#/components/schemas/Brand')
                    ),
                ]
            )
        )
    )]
    public function index(BrandFilter $brandFilter): JsonResponse
    {
        return parent::baseIndex($brandFilter);
    }

    #[OA\Post(
        path: '/api/admin/brands',
        description: 'Create a new brand',
        summary: 'Create brand',
        security: [['Bearer' => []]],
        tags: ['Admin Brand'],

    )]
     #[OA\RequestBody(
        content: new OA\MediaType(
            mediaType: 'multipart/form-data',
            schema: new OA\Schema(
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Update Engine Parts'),
                    new OA\Property(property: 'description', type: 'string', example: 'Update Spare parts related to engines'),
                    new OA\Property(property: 'shortDescription', type: 'string', example: 'Update Spare parts related to engines'),
                    new OA\Property(property: 'publish', type: 'boolean', example: false),
                    new OA\Property(property: 'featured', type: 'boolean', example: true),
                ],
                required: ['name'],
            )
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'Returns created brand',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(ref: '#/components/schemas/Brand')
        )
    )]
    public function store(BrandRequest $request): JsonResponse
    {
        return parent::baseStore($request);
    }

    #[OA\Get(
        path: '/api/admin/brands/{brand}',
        description: 'Get one brand by ID',
        summary: 'Get brand details',
        security: [['Bearer' => []]],
        tags: ['Admin Brand'],

    )]
    #[OA\Parameter(
        name: 'brand',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer'),
        description: 'Brand ID'
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns brand details',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(ref: '#/components/schemas/Brand')
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'Brand not found'
    )]
    public function show(Brand $brand): JsonResponse
    {
        return parent::baseShow($brand);
    }

    #[OA\Put(
        path: '/api/admin/brands/{brand}',
        description: 'Update brand by ID',
        summary: 'Update brand',
        security: [['Bearer' => []]],
        tags: ['Admin Brand'],
        parameters: [new OA\Parameter(ref: "#/components/parameters/x-locale")],

    )]
    #[OA\Parameter(
        name: 'brand',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer'),
        description: 'Brand ID'
    )]
    #[OA\RequestBody(
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Update Engine Parts'),
                    new OA\Property(property: 'description', type: 'string', example: 'Update Spare parts related to engines'),
                    new OA\Property(property: 'shortDescription', type: 'string', example: 'Update Spare parts related to engines'),
                    new OA\Property(property: 'publish', type: 'boolean', example: false),
                    new OA\Property(property: 'featured', type: 'boolean', example: false),
                ]
            )
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns updated brand',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(ref: '#/components/schemas/Brand')
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'Brand not found'
    )]
    public function update(BrandRequest $request, Brand $brand): JsonResponse
    {
        return parent::baseUpdate($request, $brand);
    }

    #[OA\Delete(
        path: '/api/admin/brands/{brand}',
        description: 'Delete brand by ID',
        summary: 'Delete brand',
        security: [['Bearer' => []]],
        tags: ['Admin Brand']
    )]
    #[OA\Parameter(
        name: 'brand',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer'),
        description: 'Brand ID'
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns deleted brand'
    )]
    #[OA\Response(
        response: 404,
        description: 'Brand not found'
    )]
    public function destroy(Brand $brand): JsonResponse
    {

        return parent::baseDestroy($brand);
    }
}
