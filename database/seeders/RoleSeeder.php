<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_array = [
            'admin',
            'customer',
        ];

        foreach ($role_array as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
    }
}
