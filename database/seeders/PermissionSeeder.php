<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insert(
            [
                'name' => 'Просмотр админ панели',
                'slug' => 'view-admin-panel',
                'global' => '1',
            ]
        );

        DB::table('permissions')->insert(
            [
                'name' => 'Просмотр ролей',
                'slug' => 'view-role',
                'global' => '1',
            ]
        );

        DB::table('permissions')->insert(
            [
                'name' => 'Создание ролей',
                'slug' => 'create-role',
                'global' => '1',
            ],
        );
    }
}
