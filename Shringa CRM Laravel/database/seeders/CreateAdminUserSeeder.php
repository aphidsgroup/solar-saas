<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Check if admin user already exists
        $admin = User::where('email', 'admin@shringa.com')->first();
        
        if (!$admin) {
            // Create admin user
            $admin = User::create([
                'name' => 'Admin User',
                'email' => 'admin@shringa.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]);
        }
        
        // Assign admin role
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
            echo "Admin role assigned to user: " . $admin->email . "\n";
        } else {
            echo "User already has admin role: " . $admin->email . "\n";
        }
        
        // Also create some demo users with different roles
        $users = [
            ['name' => 'Designer User', 'email' => 'designer@shringa.com', 'role' => 'designer'],
            ['name' => 'Manager User', 'email' => 'manager@shringa.com', 'role' => 'manager'],
            ['name' => 'Employee User', 'email' => 'employee@shringa.com', 'role' => 'employee'],
        ];
        
        foreach ($users as $userData) {
            $user = User::where('email', $userData['email'])->first();
            
            if (!$user) {
                $user = User::create([
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => Hash::make('password123'),
                    'email_verified_at' => now(),
                ]);
                
                $user->assignRole($userData['role']);
                echo "Created user: " . $user->email . " with role: " . $userData['role'] . "\n";
            }
        }
    }
} 