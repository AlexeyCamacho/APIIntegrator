<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert(
            [
                'name' => 'Администратор',
                'slug' => 'admin',
                'global' => '1',
            ],
        );

        DB::table('roles')->insert(
            [
                'name' => 'Модератор',
                'slug' => 'moder',
                'global' => '1',
            ],
        );

        DB::table('roles')->insert(
            [
                'name' => 'Пользователь',
                'slug' => 'user',
                'global' => '1',
            ],
        );

        DB::table('roles')->insert(
            [
                'name' => 'Владелец',
                'slug' => 'owner',
                'global' => '0',
            ],
        );

        DB::table('roles')->insert(
            [
                'name' => 'Сотрудник',
                'slug' => 'member',
                'global' => '0',
            ],
        );

        DB::table('roles')->insert(
            [
                'name' => 'Наблюдатель',
                'slug' => 'observer',
                'global' => '0',
            ],
        );
    }
}
