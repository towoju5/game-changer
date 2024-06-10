<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        //Creating Permissions
        \DB::table('permissions')->insert([
            [
                'name' => 'Add User',
                'guard_name' => 'web',
            ],
            [
                'name' => 'View User',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Edit User',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Delete User',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Verify User Documents',
                'guard_name' => 'web',
            ],
            [
                'name' => 'View User Documents',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Add Role',
                'guard_name' => 'web',
            ],
            [
                'name' => 'View Role',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Edit Role',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Delete Role',
                'guard_name' => 'web',
            ],
            [
                'name' => 'View Marketing',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Edit Marketing',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Delete Marketing',
                'guard_name' => 'web',
            ],
            [
                'name' => 'View Template',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Edit Template',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Delete Template',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Edit WelcomeNote',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Delete WelcomeNote',
                'guard_name' => 'web',
            ],
            [
                'name' => 'View WelcomeNote',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Edit GeneralSettings',
                'guard_name' => 'web',
            ],

        ]);

        //Creating Super Admin Role
        $super_admin = Role::create([
            'name' => 'Super Admin',
            'description' => 'This Role has Complete Authority, Not Modifiable.',
            'guard_name' => 'web'  
        ]);

        //Assigning Super Admin Role
        User::find(1)->assignRole($super_admin);

        //Creating User Role
        Role::create([
            'name' => 'User',
            'description' => 'This Role has Limited Authority, Modifiable.',
            'guard_name' => 'web'  
        ]);

        //Creating Administrator Role
        $administrator = Role::create([
            'name' => 'Administrator',
            'description' => 'This Role has Moderate Authority, Modifiable.',
            'guard_name' => 'web'  
        ]);

        //Assigning Administrator Role Permissions
        $administrator->syncPermissions([
            'View User',
            'Verify User Documents'
        ]);

        //Assigning Admin Role
        User::find(2)->assignRole($administrator);

        //Assigning Admin#1 Role
        User::find(3)->assignRole($administrator);
    }
}