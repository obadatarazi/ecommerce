<?php

namespace App\Http\Controllers\Api\Admin;

use App\Constant\PermissionType;
use App\Constant\SerializedGroup;
use App\Http\Controllers\Api\ApiController;
use App\Http\QueryFilter\RoleFilter;
use App\Http\Requests\Admin\RoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class AdminRoleController extends ApiController
{
    public function __construct(protected RoleService $roleService)
    {
        $this->permissionPrefix = PermissionType::PermissionManageRole->getSection();
        $this->resource = RoleResource::class;
        $this->service = $roleService;
        parent::__construct();
    }

    #[OA\Get(
        path: '/api/admin/roles',
        description: 'get all list roles',
        summary: 'get all roles',
        security: [['Bearer' => []]],
        tags: ['Admin Role'],
        parameters: [
            new OA\Parameter(ref: "#/components/parameters/direction"),
            new OA\Parameter(ref: "#/components/parameters/page"),
            new OA\Parameter(ref: "#/components/parameters/limit"),
            new OA\Parameter(
                name: 'sort',
                description: 'Specify sorting order.',
                in: 'query',
                schema: new OA\Schema(type: 'string', enum: ['id', 'name', 'created_at']),
                example: 'id'
            ),
            new OA\Parameter(
                name: 'search',
                description: 'Apply filter by name role.',
                in: 'query',
                schema: new OA\Schema(type: 'string')
            ),
            new OA\Parameter(
                name: 'code',
                description: 'Apply filter by code role.',
                in: 'query',
                schema: new OA\Schema(type: 'string', enum: ['SUPER_ADMIN', 'USER'])
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Return All Roles',
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
                                                items: new OA\Items(ref: '#/components/schemas/Role')
                                            ),
                                        ],
                                        type: 'object'
                                    ),
                                ]
                            ),
                        ]
                    )
                )
            ),
        ]
    )]
    public function index(RoleFilter $roleFilter): JsonResponse
    {
        return parent::baseIndex($roleFilter);
    }

    #[OA\Post(
        path: '/api/admin/roles',
        description: 'create new role',
        summary: 'create role',
        security: [['Bearer' => []]],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(property: 'name', type: 'string', example: 'super role'),
                        new OA\Property(property: 'standard', type: 'boolean', example: true),
                        new OA\Property(property: 'permissions', type: 'array', items: new OA\Items(type: 'integer'), example: [1]),
                    ]
                )
            )
        ),
        tags: ['Admin Role'],
        parameters: [new OA\Parameter(ref: "#/components/parameters/x-locale")],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Returns Created Role',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(
                        properties: [
                            new OA\Property(property: 'success', type: 'boolean', example: true),
                            new OA\Property(property: 'data', ref: '#/components/schemas/Role', type: 'object'),
                        ]
                    )
                )
            ),
        ]
    )]
    public function store(RoleRequest $request): JsonResponse
    {
        $role = $this->roleService->add($request->validated());

        return $this
            ->setResourceClass(RoleResource::class)
            ->setSerializedGroup(SerializedGroup::Details->value)
            ->successResponse($role, 201);
    }

    #[OA\Get(
        path: '/api/admin/roles/{role}',
        description: 'Fetches a single role by ID',
        summary: 'Get one role',
        security: [['Bearer' => []]],
        tags: ['Admin Role'],
        parameters: [
            new OA\Parameter(ref: "#/components/parameters/x-locale"),
            new OA\Parameter(
                name: 'role',
                description: 'the role to retrieve',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer'),
                example: 1
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Returns Get One Role',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(
                        properties: [
                            new OA\Property(property: 'success', type: 'boolean', example: true),
                            new OA\Property(property: 'data', ref: '#/components/schemas/Role', type: 'object'),
                        ]
                    )
                )
            ),
        ]
    )]
    public function show(Role $role): JsonResponse
    {
        return parent::baseShow($role);
    }

    #[OA\Put(
        path: '/api/admin/roles/{role}',
        description: 'update one role',
        summary: 'update role',
        security: [['Bearer' => []]],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(property: 'name', type: 'string', example: 'super role'),
                        new OA\Property(property: 'standard', type: 'boolean', example: true),
                        new OA\Property(property: 'permissions', type: 'array', items: new OA\Items(type: 'integer'), example: [1]),
                    ]
                )
            )
        ),
        tags: ['Admin Role'],
        parameters: [
            new OA\Parameter(ref: "#/components/parameters/x-locale"),
            new OA\Parameter(
                name: 'role',
                description: 'role to retrieve',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer'),
                example: 1
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Returns Updated Role',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(
                        properties: [
                            new OA\Property(property: 'success', type: 'boolean', example: true),
                            new OA\Property(property: 'data', ref: '#/components/schemas/Role', type: 'object'),
                        ]
                    )
                )
            ),
        ]
    )]
    public function update(RoleRequest $request, Role $role): JsonResponse
    {
        $role = $this->roleService->update($request->validated(), $role);

        return $this
            ->setResourceClass(RoleResource::class)
            ->setSerializedGroup(SerializedGroup::Details->value)
            ->successResponse($role);
    }

    #[OA\Delete(
        path: '/api/admin/roles/{role}',
        description: 'delete a single role by ID',
        summary: 'delete role',
        security: [['Bearer' => []]],
        tags: ['Admin Role'],
        parameters: [
            new OA\Parameter(ref: "#/components/parameters/x-locale"),
            new OA\Parameter(
                name: 'role',
                description: 'role to retrieve',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer'),
                example: 1
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Returns Deleted Role',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(
                        properties: [
                            new OA\Property(property: 'success', type: 'boolean', example: true),
                            new OA\Property(property: 'data', ref: '#/components/schemas/Role', type: 'object'),
                        ]
                    )
                )
            ),
        ]
    )]
    public function destroy(Role $role): JsonResponse
    {
        return parent::baseDestroy($role);
    }
}
