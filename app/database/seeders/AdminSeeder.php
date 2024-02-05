<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Создание суперпользователя
     * Run the database seeds.
     */
    public function run(): void
    {
        /** Получает роль из бд */
        $role_root = Role::where('slug', 'root')->first();

        /** Создает пользователя */
        $user_root = new User();
        $user_root->name = 'Admin';
        $user_root->email = 'admin@pochta.ru';
        $user_root->password = bcrypt('admin');
        $user_root->save();

        /** Создает связь пользователя и роли */
        $user_root->roles()->attach($role_root);
    }
}
