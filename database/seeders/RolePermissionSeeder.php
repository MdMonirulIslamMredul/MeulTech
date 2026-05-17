<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Permission groups and permissions
        $permissions = [
            'products.view',
            'products.create',
            'products.update',
            'products.delete',
            'categories.view',
            'categories.create',
            'categories.update',
            'categories.delete',
            'brands.view',
            'brands.create',
            'brands.update',
            'brands.delete',
            'orders.view',
            'orders.update',
            'orders.manage',
            'coupons.manage',
            'flashsales.manage',
            'users.manage',
            'blogs.manage',
            'settings.manage',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Roles
        $super = Role::firstOrCreate(['name' => 'Super Admin']);
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $staff = Role::firstOrCreate(['name' => 'Staff']);
        $customer = Role::firstOrCreate(['name' => 'Customer']);

        // Assign wide permissions to Super Admin and Admin
        $super->givePermissionTo(Permission::all());
        $admin->givePermissionTo([
            'products.view',
            'products.create',
            'products.update',
            'products.delete',
            'categories.view',
            'categories.create',
            'categories.update',
            'categories.delete',
            'brands.view',
            'brands.create',
            'brands.update',
            'brands.delete',
            'orders.view',
            'orders.update',
            'coupons.manage',
            'flashsales.manage',
            'blogs.manage'
        ]);

        $staff->givePermissionTo([
            'products.view',
            'products.create',
            'products.update',
            'orders.view'
        ]);

        // Customers get minimal permissions (managed via policies)
    }
}
