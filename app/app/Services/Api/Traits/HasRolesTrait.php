<?php

namespace App\Services\Api\Traits;

use App\Models\Role;

trait HasRolesTrait
{
    /**
     * Отношение между пользователями и ролями
     * Многие ко многим
     * @return mixed
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class,'users_roles');
    }

    /**
     * Проверяет роль текущего пользователя с запрошенной ролью.
     * Будут ли защищеные данные доступны текущему пользователю.
     * @param mixed $role
     * @return bool
     */
    public function hasRole($role)
    {
        if ($this->roles->contains('slug', $role))
        {
            return true;
        }
        return false;
    }
}
