<?php

namespace App\Services;

use App\Exceptions\Custom\UnauthorizedException;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Str;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\Token;

class AuthService
{
    protected $userService;
    protected RefreshTokenRepository $refreshTokenRepository;

    public function __construct(UserService $userService, RefreshTokenRepository $refreshTokenRepository)
    {
        $this->userService = $userService;
        $this->refreshTokenRepository = $refreshTokenRepository;
    }

    /**
     * @throws UnauthorizedException
     */
    public function login(array $credentials): bool | array
    {
        if (auth()->attempt($credentials)) {
            $user = auth()->user();

            $token = $this->createToken($user);

            return [
                "user" => $user,
                "token" => $token['token'],
                "refreshToken" => $token['refreshToken']
            ];

        }
        throw new UnauthorizedException(__('phone_number_or_password_invalid'), null, 401);
    }

    public function createToken(User $user, $name = 'API Token'): array
    {
        $accessToken = $user->createToken($name);

        $refreshToken = $this->createRefreshToken($accessToken->token);

        return [
            'token' => $accessToken->accessToken,
            'refreshToken' => $refreshToken,
        ];
    }

    public function createRefreshToken($accessToken): string
    {
        $refreshToken = new RefreshToken();
        $refreshToken->id = Str::uuid();
        $refreshToken->access_token_id = $accessToken->id;
        $refreshToken->revoked = false;
        $refreshToken->expires_at = now()->addDays(30);
        $refreshToken->save();

        return $refreshToken->id;
    }

    /**
     * @throws AuthenticationException
     */
    public function refreshToken(string $refreshToken): array
    {
        $refreshTokenRecord = RefreshToken::where('id', $refreshToken)->first();

        if (!$refreshTokenRecord || $refreshTokenRecord->revoked) {
            throw new AuthenticationException(__('Invalid or expired refresh token.'));
        }

        $accessToken = Token::where('id', $refreshTokenRecord->access_token_id)->first();

        if (!$accessToken || $accessToken->revoked) {
            throw new AuthenticationException(__('Invalid access token.'));
        }

        $accessToken->revoke();
        $refreshTokenRecord->revoke();

        $user = User::find($accessToken->user_id);

        $newAccessToken = $user->createToken('API Token');
        $newAccessTokenId = $newAccessToken->token->id;

        $newRefreshToken = new RefreshToken();
        $newRefreshToken->id = Str::uuid();
        $newRefreshToken->access_token_id = $newAccessTokenId;
        $newRefreshToken->revoked = false;
        $newRefreshToken->expires_at = now()->addDays(30);
        $newRefreshToken->save();

        return [
            'token' => $newAccessToken->accessToken,
            'refreshToken' => $newRefreshToken->id,
        ];
    }


    public function me(): User
    {
        $user = auth()->user();

        $user->load('roles.permissions');

        $user->roles->transform(function ($role) {
            return [
                'id' => $role->id,
                'name' => $role->name,
                'permission' => $role->permissions->pluck('name'),
            ];
        });

        return $user;
    }

    public function getMyRoles($user)
    {
        $roles = $user->roles()->with('permissions')->get();

        return $roles->map(function ($role) {
            return [
                'id' => $role->id,
                'name' => $role->name,
                'permission' => $role->permissions->pluck('name'),
            ];
        });
    }
}
