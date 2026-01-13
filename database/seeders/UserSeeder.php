<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed default admin and staff accounts for login testing.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin JoyMeter',
                'email' => 'admin@joymeter.test',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ],
            [
                'name' => 'Karyawan JoyMeter',
                'email' => 'karyawan@joymeter.test',
                'password' => Hash::make('karyawan123'),
                'role' => 'staff',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}

