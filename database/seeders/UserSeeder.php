<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin POS',
            'email' => 'admin@pos.com',
            'password' => Hash::make('minmin123'),
            'role' => 'admin',
        ]);

        // Kasir
        User::create([
            'name' => 'Kasir POS',
            'email' => 'kasir@pos.com',
            'password' => Hash::make('sirsir123'),
            'role' => 'kasir',
        ]);
    }
}
