<?php

namespace App\Http\Controllers\Api\Admin;

use App\Constant\PermissionType;
use App\Http\Controllers\Api\ApiController;
use App\Http\QueryFilter\CategoryFilter;
use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class AdminCategoryController extends ApiController
{
    public function __construct(protected CategoryService $categoryService)
    {
        $this->permissionPrefix = PermissionType::PermissionManageCategory->getSection();
        $this->resource = CategoryResource::class;
        $this->service = $categoryService;
        parent::__construct();
    }

    #[OA\Get(
        path: '/api/admin/categories',
        description: 'Get all categories',
        summary: 'List categories',
        security: [['Bearer' => []]],
        tags: ['Admin Category'],
       )]
    #[OA\Parameter(ref: "#/components/parameters/x-locale")]
    #[OA\Parameter(ref: "#/components/parameters/direction")]
    #[OA\Parameter(ref: "#/components/parameters/page")]
    #[OA\Parameter(ref: "#/components/parameters/limit")]
    #[OA\Parameter(
        name: 'search',
        description: 'Apply filter by category name.',
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

    #[OA\Response(
        response: 200,
        description: 'Returns all categories',
        content: new OA\MediaType(
            mediaType: 'multipart/form-data',
            schema: new OA\Schema(
                properties: [
                    new OA\Property(
                        property: 'data',
                        type: 'array',
                        items: new OA\Items(ref: '#/components/schemas/Category')
                    ),
                ]
            )
        )
    )]
    public function index(CategoryFilter $categoryFilter): JsonResponse
    {
        return parent::baseIndex($categoryFilter);
    }

    #[OA\Post(
        path: '/api/admin/categories',
        description: 'Create a new category',
        summary: 'Create category',
        security: [['Bearer' => []]],
        tags: ['Admin Category'],

    )]
    #[OA\RequestBody(
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(
                required: ['name'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Engine Parts'),
                    new OA\Property(property: 'description', type: 'string', example: 'Spare parts related to engines'),
                    new OA\Property(property: 'publish', type: 'boolean', example: true),
                ]
            )
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'Returns created category',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(ref: '#/components/schemas/Category')
        )
    )]
    public function store(CategoryRequest $request): JsonResponse
    {
        return parent::baseStore($request);
    }

    #[OA\Get(
        path: '/api/admin/categories/{category}',
        description: 'Get one category by ID',
        summary: 'Get category details',
        security: [['Bearer' => []]],
        tags: ['Admin Category'],

    )]
    #[OA\Parameter(
        name: 'category',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer'),
        description: 'Category ID'
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns category details',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(ref: '#/components/schemas/Category')
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'Category not found'
    )]
    public function show(Category $category): JsonResponse
    {
        return parent::baseShow($category);
    }

    #[OA\Put(
        path: '/api/admin/categories/{category}',
        description: 'Update category by ID',
        summary: 'Update category',
        security: [['Bearer' => []]],
        tags: ['Admin Category'],
        parameters: [new OA\Parameter(ref: "#/components/parameters/x-locale")],

    )]
    #[OA\Parameter(
        name: 'category',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer'),
        description: 'Category ID'
    )]
    #[OA\RequestBody(
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Updated category name'),
                    new OA\Property(property: 'description', type: 'string', example: 'Updated description'),
                    new OA\Property(property: 'publish', type: 'boolean', example: true),
                ]
            )
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns updated category',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(ref: '#/components/schemas/Category')
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'Category not found'
    )]
    public function update(CategoryRequest $request, Category $category): JsonResponse
    {
        return parent::baseUpdate($request, $category);
    }

    #[OA\Delete(
        path: '/api/admin/categories/{category}',
        description: 'Delete category by ID',
        summary: 'Delete category',
        security: [['Bearer' => []]],
        tags: ['Admin Category']
    )]
    #[OA\Parameter(
        name: 'category',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer'),
        description: 'Category ID'
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns deleted category'
    )]
    #[OA\Response(
        response: 404,
        description: 'Category not found'
    )]
    public function destroy(Category $category): JsonResponse
    {

        return parent::baseDestroy($category);
    }
}
