<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            //'user_id' => 'admin_' . uniqid(),
            'username' => 'admin',
            'full_name' => 'Admin User',
            'email' => 'admin@deskalink.com',
            'phone' => '1234567890',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);
    }
}