<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@shringacrm.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
            'position' => 'Administrator',
            'phone' => '9876543210',
        ]);
        
        // Create designer user
        User::create([
            'name' => 'Designer User',
            'email' => 'designer@shringacrm.com',
            'password' => Hash::make('password'),
            'role' => 'designer',
            'email_verified_at' => now(),
            'position' => 'Interior Designer',
            'phone' => '9876543211',
        ]);
        
        // Create project manager user
        User::create([
            'name' => 'Project Manager',
            'email' => 'pm@shringacrm.com',
            'password' => Hash::make('password'),
            'role' => 'pm',
            'email_verified_at' => now(),
            'position' => 'Project Manager',
            'phone' => '9876543212',
        ]);
        
        // Create engineer user
        User::create([
            'name' => 'Engineer User',
            'email' => 'engineer@shringacrm.com',
            'password' => Hash::make('password'),
            'role' => 'engineer',
            'email_verified_at' => now(),
            'position' => 'Site Engineer',
            'phone' => '9876543213',
        ]);
        
        // Create regular user
        User::create([
            'name' => 'Regular User',
            'email' => 'user@shringacrm.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
            'position' => 'Sales Associate',
            'phone' => '9876543214',
        ]);
        
        // Create additional users with different roles
        User::create([
            'name' => 'Anil Sharma',
            'email' => 'anil@shringacrm.com',
            'password' => Hash::make('password'),
            'role' => 'designer',
            'email_verified_at' => now(),
            'position' => 'Senior Designer',
            'phone' => '9876543215',
        ]);
        
        User::create([
            'name' => 'Priya Patel',
            'email' => 'priya@shringacrm.com',
            'password' => Hash::make('password'),
            'role' => 'pm',
            'email_verified_at' => now(),
            'position' => 'Senior Project Manager',
            'phone' => '9876543216',
        ]);
    }
}
