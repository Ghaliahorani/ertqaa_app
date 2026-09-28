<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate([
            'username' => 'admin',
            'password' => Hash::make('123456'),
            'full_name' => 'Admin User',
            'email' => 'admin@example.com',
            'phone' => '0999999999',
            'status' => 'active'
        ]);
    }
}

