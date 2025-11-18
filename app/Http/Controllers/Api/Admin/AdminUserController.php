<?php

namespace App\Http\Controllers\Api\Admin;

use App\Constant\PermissionType;
use App\Http\Controllers\Api\ApiController;
use App\Http\QueryFilter\UserFilter;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class AdminUserController extends ApiController
{
    public function __construct(protected UserService $userService)
    {
        $this->permissionPrefix = PermissionType::PermissionManageUser->getSection();
        $this->resource = UserResource::class;
        $this->service = $userService;
        parent::__construct();
    }

    #[OA\Get(
        path: '/api/admin/users',
        description: 'get all list user',
        summary: 'get all users',
        security: [['Bearer' => []]],
        tags: ['Admin User'],
    )]
    #[OA\Parameter(ref: "#/components/parameters/x-locale")]
    #[OA\Parameter(ref: "#/components/parameters/direction")]
    #[OA\Parameter(ref: "#/components/parameters/page")]
    #[OA\Parameter(ref: "#/components/parameters/limit")]
    #[OA\Parameter(
        name: 'search',
        description: 'Apply filter by user name.',
        in: 'query',
        required: false,
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'email',
        description: 'Apply filter by email.',
        in: 'query',
        required: false,
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'phoneNumber',
        description: 'Apply filter by phone number user.',
        in: 'query',
        required: false,
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'gender',
        description: 'Apply filter by gender user.',
        in: 'query',
        required: false,
        schema: new OA\Schema(type: 'string', enum: ['MALE', 'FEMALE']),
    )]
    #[OA\Parameter(
        name: 'role',
        description: 'Apply filter by user role.',
        in: 'query',
        required: false,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Response(
        response: 200,
        description: 'Return All Users',
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
                                        items: new OA\Items(ref: '#/components/schemas/User')
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
    public function index(UserFilter $userFilter): JsonResponse
    {
        return parent::baseIndex($userFilter);
    }

    /**
     * @throws \Exception
     */
    #[OA\Post(
        path: '/api/admin/users',
        description: 'create new user',
        summary: 'create user',
        security: [['Bearer' => []]],
        tags: ['Admin User'],
        parameters: [new OA\Parameter(ref: "#/components/parameters/x-locale")],
    )]
    #[OA\RequestBody(
        content: new OA\MediaType(
            mediaType: 'multipart/form-data',
            schema: new OA\Schema(
                properties: [
                    new OA\Property(property: 'avatar', type: 'file'),
                    new OA\Property(property: 'fullName', type: 'string', example: 'super user'),
                    new OA\Property(property: 'email', type: 'string', example: 'user@user.com'),
                    new OA\Property(property: 'password', type: 'string', example: 'test1234'),
                    new OA\Property(property: 'passwordConfirmation', type: 'string', example: 'test1234'),
                    new OA\Property(property: 'phoneNumber', type: 'string', example: '0977845129'),
                    new OA\Property(property: 'gender', type: 'string', enum: ['MALE', 'FEMALE'], example: 'MALE'),
                    new OA\Property(property: 'dateOfBirth', type: 'string', example: '2024-07-03'),
                    new OA\Property(property: 'roles[]', type: 'array', items: new OA\Items(type: 'integer'), example: [1]),
                ]
            )
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns Created User',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(
                properties: [
                    new OA\Property(property: 'success', type: 'boolean', example: true),
                    new OA\Property(property: 'data', ref: '#/components/schemas/User', type: 'object'),
                ]
            )
        )
    )]
    public function store(UserRequest $request): JsonResponse
    {
        return parent::baseStore($request);
    }

    #[OA\Get(
        path: '/api/admin/users/{user}',
        description: 'Fetches a single user by ID',
        summary: 'Get one user',
        security: [['Bearer' => []]],
        tags: ['Admin User'],
    )]
    #[OA\Parameter(ref: "#/components/parameters/x-locale")]
    #[OA\Parameter(
        name: 'user',
        description: 'the user to retrieve',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer'),
        example: 1
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns Get One User',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(
                properties: [
                    new OA\Property(property: 'success', type: 'boolean', example: true),
                    new OA\Property(property: 'data', ref: '#/components/schemas/User', type: 'object'),
                ]
            )
        )
    )]
    public function show(User $user): JsonResponse
    {
        return parent::baseShow($user);
    }

    #[OA\Post(
        path: '/api/admin/users/{user}',
        description: 'Update one user',
        summary: 'Update user',
        security: [['Bearer' => []]],
        tags: ['Admin User'],
    )]
    #[OA\Parameter(ref: "#/components/parameters/x-locale")]
    #[OA\Parameter(
        name: 'user',
        description: 'the user to update',
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
                    new OA\Property(property: 'avatar', type: 'file'),
                    new OA\Property(property: 'fullName', type: 'string', example: 'super user'),
                    new OA\Property(property: 'email', type: 'string', example: 'user@user.com'),
                    new OA\Property(property: 'password', type: 'string', example: 'test1234'),
                    new OA\Property(property: 'passwordConfirmation', type: 'string', example: 'test1234'),
                    new OA\Property(property: 'phoneNumber', type: 'string', example: '0977845129'),
                    new OA\Property(property: 'gender', type: 'string', enum: ['MALE', 'FEMALE'], example: 'MALE'),
                    new OA\Property(property: 'dateOfBirth', type: 'string', example: '2024-07-03'),
                    new OA\Property(property: 'roles[]', type: 'array', items: new OA\Items(type: 'integer'), example: [1]),
                ]
            )
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns Updated User',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(
                properties: [
                    new OA\Property(property: 'success', type: 'boolean', example: true),
                    new OA\Property(property: 'data', ref: '#/components/schemas/User', type: 'object'),
                ]
            )
        )
    )]
    public function update(UserRequest $request, User $user): JsonResponse
    {
        return parent::baseUpdate($request, $user);
    }

    #[OA\Delete(
        path: '/api/admin/users/{user}',
        description: 'delete a single user by ID',
        summary: 'delete user',
        security: [['Bearer' => []]],
        tags: ['Admin User'],
    )]
    #[OA\Parameter(ref: "#/components/parameters/x-locale")]
    #[OA\Parameter(
        name: 'user',
        description: 'the user to retrieve',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer'),
        example: 1
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns Deleted User',
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(
                properties: [
                    new OA\Property(property: 'success', type: 'boolean', example: true),
                    new OA\Property(property: 'data', ref: '#/components/schemas/User', type: 'object'),
                ]
            )
        )
    )]
    public function destroy(User $user): JsonResponse
    {
        return parent::baseDestroy($user);
    }
}
