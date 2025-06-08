<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                //'user_id' => 'user000001',
                'google_id' => null,
                'username' => 'admin',
                'password' => '$2y$12$EZ.zrtnyp4qAlhod4nzW5.AHBVzPQYmClHvzYgD28eYFVLbi2Vy3S',
                'full_name' => 'Admin User',
                'email' => 'admin@deskalink.com',
                'phone' => '1234567890',
                'role' => 'admin',
                'status' => 'active',
                'profile_photo_url' => 'https://i.postimg.cc/qqChrG8y/profile.png',
                'description' => null,
                'is_profile_completed' => 0,
                'balance' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                //'user_id' => 'user000002',
                'google_id' => null,
                'username' => 'AdminUmar',
                'password' => '$2y$12$M5u3BL3XuDT/SkICRD8I/.NIW8gDA.nZSZo9dmJseuhJBHi7XiYpy',
                'full_name' => 'Admin Umar',
                'email' => 'adminumar@mail.com',
                'phone' => '083146978084',
                'role' => 'admin',
                'status' => 'active',
                'profile_photo_url' => 'https://i.postimg.cc/qqChrG8y/profile.png',
                'description' => null,
                'is_profile_completed' => 0,
                'balance' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                //'user_id' => 'user000003',
                'google_id' => null,
                'username' => 'PartnerDimas',
                'password' => '$2y$12$INbgLCZLPvrmv.D66YQ2HOdgUWmWLTRu/RF3JqjnEksGA.Rowivhy',
                'full_name' => 'Partner Dimas',
                'email' => 'partnerdimas@mail.com',
                'phone' => '083123456789',
                'role' => 'partner',
                'status' => 'active',
                'profile_photo_url' => 'https://i.postimg.cc/qqChrG8y/profile.png',
                'description' => null,
                'is_profile_completed' => 0,
                'balance' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
