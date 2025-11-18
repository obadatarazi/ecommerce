<?php

namespace Database\Seeders;

use App\Constant\RoleCode;
use App\Enum\UserGender;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $admin = new User();

        $admin->full_name = 'Super Admin';
        $admin->email = 'admin@admin.com';
        $admin->phone_number = '0966214578';
        $admin->password = bcrypt('password');
        $admin->gender = UserGender::MALE->value;

        $admin->save();

        $superAdminRole = Role::create(['guard_name' => 'api', 'name' => 'super-admin', 'code' => RoleCode::SuperAdmin->value, 'standard' => true]);
        $admin->syncRoles([$superAdminRole]);
    }
}
