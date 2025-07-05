<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view leads',
            'create leads',
            'edit leads',
            'delete leads',
            
            'view clients',
            'create clients',
            'edit clients',
            'delete clients',
            
            'view projects',
            'create projects',
            'edit projects',
            'delete projects',
            
            'view quotations',
            'create quotations',
            'edit quotations',
            'delete quotations',
            
            'view invoices',
            'create invoices',
            'edit invoices',
            'delete invoices',
            
            'view tasks',
            'create tasks',
            'edit tasks',
            'delete tasks',
            
            'view documents',
            'create documents',
            'edit documents',
            'delete documents',
            
            'view daily-reports',
            'create daily-reports',
            'edit daily-reports',
            'delete daily-reports',
            
            'view communication-logs',
            'create communication-logs',
            'edit communication-logs',
            'delete communication-logs',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // update cache to know about the newly created permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles and assign permissions
        
        // Admin role - full access
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        // Designer role - design-focused permissions
        $designer = Role::create(['name' => 'designer']);
        $designer->givePermissionTo([
            'view leads',
            'edit leads',
            'view clients',
            'edit clients',
            'view projects',
            'create projects',
            'edit projects',
            'view quotations',
            'create quotations',
            'edit quotations',
            'view tasks',
            'create tasks',
            'edit tasks',
            'view documents',
            'create documents',
            'edit documents',
            'view daily-reports',
            'create daily-reports',
            'view communication-logs',
            'create communication-logs',
        ]);

        // Manager role - management permissions
        $manager = Role::create(['name' => 'manager']);
        $manager->givePermissionTo([
            'view leads',
            'create leads',
            'edit leads',
            'view clients',
            'create clients',
            'edit clients',
            'view projects',
            'edit projects',
            'view quotations',
            'edit quotations',
            'view invoices',
            'create invoices',
            'edit invoices',
            'view tasks',
            'create tasks',
            'edit tasks',
            'view daily-reports',
            'view communication-logs',
            'create communication-logs',
        ]);

        // Employee role - basic permissions
        $employee = Role::create(['name' => 'employee']);
        $employee->givePermissionTo([
            'view leads',
            'view clients',
            'view projects',
            'view quotations',
            'view tasks',
            'edit tasks',
            'view documents',
            'view daily-reports',
            'create daily-reports',
            'view communication-logs',
            'create communication-logs',
        ]);
    }
}
