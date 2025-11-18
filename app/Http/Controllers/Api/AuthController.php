<?php

namespace App\Http\Controllers\Api;

use App\Constant\SerializedGroup;
use App\Exceptions\Custom\UnauthorizedException;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\Api\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use App\Services\UserService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use function App\Http\Controllers\Api\Api\auth;

class AuthController extends ApiController
{
    private UserService $userService;
    public function __construct(protected AuthService $authService, UserService $userService)
    {
        $this->userService = $userService;
    }

    #[OA\Post(
        path: '/api/auth/login',
        description: '',
        summary: 'login',
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(property: 'phoneNumber', type: 'string', example: '0999999999'),
                        new OA\Property(property: 'password', type: 'string', example: 'password'),
                    ]
                )
            )
        ),
        tags: ['Auth'],
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
        path: '/api/auth/refresh-token',
        description: '',
        summary: 'refresh token',
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
        tags: ['Auth'],
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
        path: '/api/me/profile',
        description: 'get profile mobile',
        summary: 'Get mobile profile',
        security: [['Bearer' => []]],
        tags: ['Auth'],
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

    #[OA\Post(
        path: '/api/me/profile/update',
        description: '',
        summary: 'update profile mobile',
        security: [['Bearer' => []]],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(property: '_method', type: 'text', example: 'PUT'),
                        new OA\Property(property: 'avatar', type: 'file'),
                        new OA\Property(property: 'fullName', type: 'string', example: 'full name super user mobile'),
                        new OA\Property(property: 'email', type: 'string', example: 'user@email.com'),
                        new OA\Property(property: 'gender', type: 'string', enum: ['MALE', 'FEMALE'], example: 'MALE'),
                        new OA\Property(property: 'dateOfBirth', type: 'string', example: '2024-07-03'),
                        new OA\Property(property: 'phoneNumber', type: 'string', example: '0977845129'),
                    ]
                )
            )
        ),
        tags: ['Auth'],
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
    public function updateProfile(UpdateProfileRequest $updateProfileRequest): JsonResponse
    {
        $user = auth()->user();

        $data = $this->userService->updateProfile($updateProfileRequest->validated(), $user);

        return $this
            ->setResourceClass(UserResource::class)
            ->setSerializedGroup(SerializedGroup::Details->value)
            ->successResponse($data, 201);
    }
}
