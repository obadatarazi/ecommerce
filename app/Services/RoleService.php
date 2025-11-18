<?php

namespace App\Services;

use App\Constant\PermissionType;
use App\Constant\RoleCode;
use App\Models\Role;
use App\Models\User;

class RoleService extends BaseService
{
    public function __construct()
    {
        $this->model = Role::class;
        parent::__construct();
    }

    public function getAll(): array
    {
        $permissions = PermissionType::cases();

        return array_map(function (PermissionType $permission) {
            return $permission->getPermission();
        }, $permissions);
    }

    public function getBySection(): array
    {
        $roles = PermissionType::cases();
        $rolesArray = [];
        foreach ($roles as $role) {
            $section = $role->getSection();
            if (count($rolesArray) == 0
                || $rolesArray[count($rolesArray) - 1]['section'] != $section)
                $rolesArray[] = [
                    'section' => $section,
                    'roles' => []
                ];
            $rolesArray[count($rolesArray) - 1]['roles'][] = [
                'role' => $role->getSection(),
                'name' => $role->getPermission(),
                'description' => $role->getDesc(),
            ];
        }
        return $rolesArray;
    }


    public function getSuperAdminRoleGroup()
    {
        return Role::query()->where('code', RoleCode::SuperAdmin->value)->first();
    }

    public function add($data): Role
    {
        $role = new Role($data);
        $role->guard_name = 'api';
        $role->code = strtoupper(str_replace(' ', '_', $data['name']));

        $role->save();

        if (isset($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        }

        return $role;
    }

    public function update($data, $role)
    {
        if (isset($data['name'])) {
            $role->code = strtoupper(str_replace(' ', '_', $data['name']));
        }

        $role->update($data);
        $role->save();

        if (isset($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        }

        return $role;
    }

    public function assignRoleUser(User $user, $roles): void
    {
        $roles = Role::whereIn('id', $roles)->pluck('name')->toArray();

        $user->syncRoles($roles);
    }
}
