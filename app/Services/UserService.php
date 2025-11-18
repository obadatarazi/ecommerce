<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserService extends BaseService
{
    const UPLOAD_FOLDER = 'users';
    public function __construct(UploadFileService $uploadFileService, protected RoleService $roleService)
    {
        $this->model = User::class;
        $this->uploadFileService = $uploadFileService;
        parent::__construct();
    }

    /**
     * @throws \Exception
     */
    public function create($data): User
    {
        $user = new User($data);
        $keyFileMaps = ['avatar_file_url' => 'avatar'];

        if ($data['password']) {
            $user->password = bcrypt($data['password']);
        }

        $this->uploadFileService->uploadFiles(
            $data,
            $keyFileMaps,
            $user,
            $this::UPLOAD_FOLDER
        );

        $user->save();

        if (isset($data['roles'])) {
            $this->roleService->assignRoleUser($user, $data['roles']);
        }

        return $user;
    }

    public function update($data, User | Model $user): User
    {
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $user->update($data);

        $keyFileMaps = ['avatar_file_url' => 'avatar'];

        $this->uploadFileService->updateFiles(
            $data,
            $keyFileMaps,
            $user,
            $this::UPLOAD_FOLDER
        );

        $user->save();

        if (isset($data['roles'])) {
            $this->roleService->assignRoleUser($user, $data['roles']);
        }

        return $user;
    }

    public function updateProfile($data, Model | User $user): User
    {
        $user->update($data);

        if (isset($data['avatar'])) {
            $keyFileMaps = ['avatar_file_url' => 'avatar'];

            $this->uploadFileService->updateFiles(
                $data,
                $keyFileMaps,
                $user,
                $this::UPLOAD_FOLDER
            );
        }

        $user->save();

        return $user;
    }
}
