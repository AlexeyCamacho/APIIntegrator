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
            'name' => 'Редактирование ролей',
            'slug' => 'edit-role',
            'global' => '1'
        ]);

        Permission::firstOrCreate([
            'name' => 'Удаление ролей',
            'slug' => 'delete-role',
            'global' => '1'
        ]);

        Permission::firstOrCreate([
            'name' => 'Просмотр пользователей',
            'slug' => 'view-user',
            'global' => '1'
        ]);

        Permission::firstOrCreate([
            'name' => 'Создание пользователей',
            'slug' => 'create-user',
            'global' => '1'
        ]);

        Permission::firstOrCreate([
            'name' => 'Изменение пользователей',
            'slug' => 'edit-user',
            'global' => '1'
        ]);

        Permission::firstOrCreate([
            'name' => 'Удаление пользователей',
            'slug' => 'delete-user',
            'global' => '1'
        ]);

        Permission::firstOrCreate([
            'name' => 'Просмотр компаний',
            'slug' => 'view-company',
            'global' => '0'
        ]);

        Permission::firstOrCreate([
            'name' => 'Просмотр компаний',
            'slug' => 'view-company-admin',
            'global' => '1'
        ]);

        Permission::firstOrCreate([
            'name' => 'Создание компаний',
            'slug' => 'create-company-admin',
            'global' => '1'
        ]);

        Permission::firstOrCreate([
            'name' => 'Изменение компаний',
            'slug' => 'edit-company',
            'global' => '0'
        ]);

        Permission::firstOrCreate([
            'name' => 'Изменение компаний',
            'slug' => 'edit-company-admin',
            'global' => '1'
        ]);

        Permission::firstOrCreate([
            'name' => 'Удаление компаний',
            'slug' => 'delete-company-admin',
            'global' => '1'
        ]);


        $admin = Role::where('slug', 'admin')->first();
        $admin->permissions()->detach();
        $admin->permissions()->attach(Permission::where('global', 1)->get()->map(function (Permission $permission) {
            return $permission;
        }));
    }
}
