<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Permission;
use App\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::firstOrCreate([
            'name' => 'Просмотр админ панели',
            'slug' => 'view-admin-panel',
            'global' => '1'
        ]);

        Permission::firstOrCreate([
            'name' => 'Просмотр ролей',
            'slug' => 'view-role',
            'global' => '1'
        ]);

        Permission::firstOrCreate([
            'name' => 'Создание ролей',
            'slug' => 'create-role',
            'global' => '1'
        ]);

        Permission::firstOrCreate([
            'name' => 'Просмотр пользователей',
            'slug' => 'view-user',
            'global' => '1'
        ]);

        $admin = Role::where('slug', 'admin')->first();
        $admin->permissions()->detach();
        $admin->permissions()->attach(Permission::all()->map(function (Permission $permission) {
            return $permission;
        }));
    }
}
