<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    public $timestamps = false;

    /**
     * Отношение между ролями и пользователями
     * Многие ко многим
     * @return mixed
     */
    public function user()
    {
        return $this->belongsToMany(User::class,'users_roles');
    }
}
