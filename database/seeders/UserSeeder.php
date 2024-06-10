<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'username' => 'Disputes',
            'email' => 'superadmin@gmail.com',
            'email_verified_at' => now(),
            'account_verification' => 'Approved',
            'password' => \Hash::make('123456'),
            'profile_picture' => 'avatar-1.jpg',
        ]);

        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'username' => 'Personal Account',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'account_verification' => 'Approved',
            'password' => \Hash::make('123456'),
            'profile_picture' => 'avatar-1.jpg',
        ]);

        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User#1',
            'username' => 'Tournament Account',
            'email' => 'admin1@gmail.com',
            'email_verified_at' => now(),
            'account_verification' => 'Approved',
            'password' => \Hash::make('123456'),
            'profile_picture' => 'avatar-1.jpg',
        ]);
    }
}