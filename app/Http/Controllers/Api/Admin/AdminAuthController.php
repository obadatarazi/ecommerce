<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exceptions\Custom\UnauthorizedException;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\LoginRequest;
use App\Services\AuthService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AdminAuthController extends ApiController
{
    public function __construct(protected AuthService $authService) {}

    #[OA\Post(
        path: '/api/admin/auth/login',
        description: '',
        summary: 'login admin',
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(property: 'phoneNumber', type: 'string', example: '0966214578'),
                        new OA\Property(property: 'password', type: 'string', example: 'password'),
                    ]
                )
            )
        ),
        tags: ['Admin Auth'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Login Success',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(
                        properties: [
                            new OA\Property(property: 'success', type: 'boolean', example: true),
                            new OA\Property(property: 'data', ref: '#/components/schemas/User', type: 'object'),
                            new OA\Property(property: 'token', type: 'string', example: 'access_token'),
                        ]
                    )
                )
            ),
        ]
    )]
    #[OA\Parameter(ref: "#/components/parameters/x-locale")]
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $userData = $request->validated();

            $data = $this->authService->login($userData);

            return $this->successResponse($data);
        } catch (UnauthorizedException $ex) {

            throw new UnauthorizedHttpException($ex->getMessage(), $ex->getMessage());
        }
    }

    #[OA\Post(
        path: '/api/admin/auth/refresh-token',
        description: '',
        summary: 'refresh token admin',
        security: [['Bearer' => []]],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(property: 'refreshToken', type: 'string', example: 'your_refresh_token'),
                    ]
                )
            )
        ),
        tags: ['Admin Auth'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Refresh Token Success',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(
                        properties: [
                            new OA\Property(property: 'success', type: 'boolean', example: true),
                            new OA\Property(property: 'data', ref: '#/components/schemas/User', type: 'object'),
                            new OA\Property(property: 'refreshToken', type: 'string', example: 'your_refresh_access_token'),
                        ]
                    )
                )
            ),
        ]
    )]
    #[OA\Parameter(ref: "#/components/parameters/x-locale")]
    public function refreshToken(Request $request): JsonResponse
    {
        try {
            $data = $this->authService->refreshToken($request->request->get('refreshToken'));

            return $this->successResponse($data);
        } catch (AuthenticationException $e) {
            throw new UnauthorizedHttpException($e->getMessage(), $e->getMessage());
        }
    }

    #[OA\Get(
        path: '/api/admin/me/profile',
        description: 'get profile',
        summary: 'Get admin profile',
        security: [['Bearer' => []]],
        tags: ['Admin Auth'],
        parameters: [new OA\Parameter(ref: "#/components/parameters/x-locale")],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Returns Profile User',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(
                        properties: [
                            new OA\Property(property: 'success', type: 'boolean', example: true),
                            new OA\Property(property: 'data', ref: '#/components/schemas/User', type: 'object'),
                        ]
                    )
                )
            ),
        ]
    )]
    public function me(): JsonResponse
    {
        $data = $this->authService->me();
        return $this->successResponse(['user' => $data]);
    }

    #[OA\Get(
        path: '/api/admin/me/roles',
        description: 'get my roles',
        summary: 'Get admin my roles',
        security: [['Bearer' => []]],
        tags: ['Admin Auth'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Returns My Roles User',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(
                        properties: [
                            new OA\Property(property: 'success', type: 'boolean', example: true),
                            new OA\Property(
                                property: 'data',
                                properties: [
                                    new OA\Property(property: 'id', type: 'integer', example: 1),
                                    new OA\Property(property: 'name', type: 'string', example: 'super-admin'),
                                    new OA\Property(
                                        property: 'permission',
                                        type: 'array',
                                        items: new OA\Items(type: 'string', example: 'MANAGE_USER')
                                    ),
                                ],
                                type: 'object'
                            ),
                        ]
                    )
                )
            ),
        ]
    )]
    public function getMyRoles(): JsonResponse
    {
        $user = Auth::user();

        $roles = $this->authService->getMyRoles($user);

        return $this->successResponse($roles);
    }
}
