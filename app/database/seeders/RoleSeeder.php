<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** Роль суперадмина */
        $root_role = new Role();
        $root_role->name = 'root';
        $root_role->slug = 'root';
        $root_role->save();

        /** Роль модератора */
        $moderator_role = new Role();
        $moderator_role->name = 'moderator';
        $moderator_role->slug = 'moderator';
        $moderator_role->save();
    }
}
