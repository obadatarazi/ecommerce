<?php

namespace App\Http\Controllers\Api\Admin;

use App\Constant\PermissionType;
use App\Http\Controllers\Api\ApiController;
use App\Http\QueryFilter\IngredientFilter;
use App\Http\Requests\Admin\IngredientRequest;
use App\Http\Resources\IngredientResource;
use App\Models\Ingredient;
use App\Services\IngredientService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class AdminIngredientController extends ApiController
{
    public function __construct(protected IngredientService $ingredientService)
    {
        $this->permissionPrefix = PermissionType::PermissionManageIngredient->getSection();
        $this->resource = IngredientResource::class;
        $this->service = $ingredientService;
        parent::__construct();
    }

    #[OA\Get(
        path: '/api/admin/ingredients',
        description: 'Get all ingredient',
        summary: 'List ingredient',
        security: [['Bearer' => []]],
        tags: ['Admin Ingredient'],
       )]
    #[OA\Parameter(ref: "#/components/parameters/x-locale")]
    #[OA\Parameter(ref: "#/components/parameters/direction")]
    #[OA\Parameter(ref: "#/components/parameters/page")]
    #[OA\Parameter(ref: "#/components/parameters/limit")]
    #[OA\Parameter(
        name: 'search',
        description: 'Apply filter by ingredient name.',
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
        description: 'Returns all ingredient',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(
                properties: [
                    new OA\Property(
                        property: 'data',
                        type: 'array',
                        items: new OA\Items(ref: '#/components/schemas/Ingredient')
                    ),
                ]
            )
        )
    )]
    public function index(IngredientFilter $ingredientFilter): JsonResponse
    {
        return parent::baseIndex($ingredientFilter);
    }

    #[OA\Post(
        path: '/api/admin/ingredients',
        description: 'Create a new ingredient',
        summary: 'Create ingredient',
        security: [['Bearer' => []]],
        tags: ['Admin Ingredient'],

    )]
    #[OA\RequestBody(
        content: new OA\MediaType(
            mediaType: 'multipart/form-data',
            schema: new OA\Schema(
                required: ['name'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Engine Parts'),
                    new OA\Property(property: 'note', type: 'string', example: 'Spare parts related to engines'),
                    new OA\Property(property: 'publish', type: 'boolean', example: true),
                ]
            )
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'Returns created Ingredient',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(ref: '#/components/schemas/Ingredient')
        )
    )]
    public function store(IngredientRequest $request): JsonResponse
    {
        return parent::baseStore($request);
    }

    #[OA\Get(
        path: '/api/admin/ingredients/{ingredient}',
        description: 'Get one ingredient by ID',
        summary: 'Get ingredient details',
        security: [['Bearer' => []]],
        tags: ['Admin Ingredient'],

    )]
    #[OA\Parameter(
        name: 'ingredient',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer'),
        description: 'Ingredient ID'
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns ingredient details',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(ref: '#/components/schemas/Ingredient')
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'Ingredient not found'
    )]
    public function show(Ingredient $ingredient): JsonResponse
    {
        return parent::baseShow($ingredient);
    }

    #[OA\Put(
        path: '/api/admin/ingredients/{ingredient}',
        description: 'Update ingredient by ID',
        summary: 'Update ingredient',
        security: [['Bearer' => []]],
        tags: ['Admin Ingredient'],
        parameters: [new OA\Parameter(ref: "#/components/parameters/x-locale")],

    )]
    #[OA\Parameter(
        name: 'ingredient',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer'),
        description: 'Ingredient ID'
    )]
    #[OA\RequestBody(
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Engine Parts'),
                    new OA\Property(property: 'note', type: 'string', example: 'Spare parts related to engines'),
                    new OA\Property(property: 'publish', type: 'boolean', example: true),                ]
            )
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns updated ingredient',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(ref: '#/components/schemas/Ingredient')
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'Ingredient not found'
    )]
    public function update(IngredientRequest $request, Ingredient $ingredient): JsonResponse
    {
        return parent::baseUpdate($request, $ingredient);
    }

    #[OA\Delete(
        path: '/api/admin/ingredients/{ingredient}',
        description: 'Delete ingredient by ID',
        summary: 'Delete ingredient',
        security: [['Bearer' => []]],
        tags: ['Admin Ingredient']
    )]
    #[OA\Parameter(
        name: 'ingredient',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer'),
        description: 'Ingredient ID'
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns deleted ingredient'
    )]
    #[OA\Response(
        response: 404,
        description: 'Ingredient not found'
    )]
    public function destroy(Ingredient $ingredient): JsonResponse
    {

        return parent::baseDestroy($ingredient);
    }
}
