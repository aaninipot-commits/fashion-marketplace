<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'superadmin@fashion.com'],
            [
                'name'     => 'Super Admin',
                'email'    => 'superadmin@fashion.com',
                'password' => Hash::make('superadmin123'),
                'role'     => 'superadmin',
            ]
        );
    }
}