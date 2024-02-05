<?php

namespace App\Services\Api\Admin;

use App\Models\Role;
use App\Models\User;

/**
 * Получает пользователя по id
 * Получает роль
 * Добавляет пользователю роль
*/
class AddAssignmentRight
{
    public function __construct($request)
    {
        /** Получает роль из бд */
        $role = Role::where('slug', $request->role)->first();

        /** Получает пользователя */
        $user = User::find($request->id);

        /** Создает связь пользователя и роли */
        $user->roles()->attach($role);
    }
}
