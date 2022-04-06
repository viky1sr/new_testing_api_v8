<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::firstOrCreate([
            'name' => 'Admin',
            'email' => 'admin@demo.com',
            'password' => \Hash::make('qweasd123'),
            'email_verified_at' => Carbon::now()
        ]);
        $admin->assignRole('admin');

        $admin = User::firstOrCreate([
            'name' => 'Customer',
            'email' => 'customer@demo.com',
            'password' => \Hash::make('qweasd123'),
            'email_verified_at' => Carbon::now()
        ]);
        $admin->assignRole('customer');
    }
}
