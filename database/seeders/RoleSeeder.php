<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::updateOrCreate(['name' => 'users'], ['name' => 'users']);
        Permission::updateOrCreate(['name' => 'dashboard'], ['name' => 'dashboard']);
        Permission::updateOrCreate(['name' => 'profile'], ['name' => 'profile']);
        Permission::updateOrCreate(['name' => 'categories'], ['name' => 'categories']);
        Permission::updateOrCreate(['name' => 'crm/special-contact'], ['name' => 'crm/special-contact']);
        Permission::updateOrCreate(['name' => 'crm/contact'], ['name' => 'crm/contact']);
        Permission::updateOrCreate(['name' => 'products/create'], ['name' => 'products/create']);
        Permission::updateOrCreate(['name' => 'products'], ['name' => 'products']);
        Permission::updateOrCreate(['name' => 'products edit'], ['name' => 'products edit']);
        Permission::updateOrCreate(['name' => 'orders/create'], ['name' => 'orders/create']);
        Permission::updateOrCreate(['name' => 'orders'], ['name' => 'orders']);
        Permission::updateOrCreate(['name' => 'orders/unpaid'], ['name' => 'orders/unpaid']);
        Permission::updateOrCreate(['name' => 'orders show'], ['name' => 'orders show']);
        Permission::updateOrCreate(['name' => 'purchases'], ['name' => 'purchases']);
        Permission::updateOrCreate(['name' => 'purchases/create'], ['name' => 'purchases/create']);
        Permission::updateOrCreate(['name' => 'purchases/open'], ['name' => 'purchases/open']);
        Permission::updateOrCreate(['name' => 'purchases/confirmed'], ['name' => 'purchases/confirmed']);
        Permission::updateOrCreate(['name' => 'purchases show'], ['name' => 'purchases show']);
        Permission::updateOrCreate(['name' => 'purchases edit'], ['name' => 'purchases edit']);
        Permission::updateOrCreate(['name' => 'inventory'], ['name' => 'inventory']);
        Permission::updateOrCreate(['name' => 'inventory/stockin'], ['name' => 'inventory/stockin']);
        Permission::updateOrCreate(['name' => 'inventory/transactions'], ['name' => 'inventory/transactions']);
        Permission::updateOrCreate(['name' => 'suppliers'], ['name' => 'suppliers']);
        Permission::updateOrCreate(['name' => 'loan-products'], ['name' => 'loan-products']);
        Permission::updateOrCreate(['name' => 'reports/sales'], ['name' => 'reports/sales']);
        Permission::updateOrCreate(['name' => 'pos'], ['name' => 'pos']);
        Permission::updateOrCreate(['name' => 'logs'], ['name' => 'logs']);

        $adminRole = Role::updateOrCreate(['name' => 'admin'], ['name' => 'admin'] );
        $salesRole = Role::updateOrCreate(['name' => 'sales'], ['name' => 'sales'] );
        $operationsRole = Role::updateOrCreate(['name' => 'operations'], ['name' => 'operations'] );

        $adminRole->givePermissionTo([
            'users',
            'dashboard',
            'profile',
            'categories',
            'crm/special-contact',
            'crm/contact',
            'products/create',
            'products',
            'products edit',
            'orders/create',
            'orders',
            'orders/unpaid',
            'orders show',
            'purchases',
            'purchases/create',
            'purchases/open',
            'purchases/confirmed',
            'purchases show',
            'purchases edit',
            'inventory',
            'inventory/stockin',
            'inventory/transactions',
            'suppliers',
            'loan-products',
            'reports/sales',
            'pos',
            'logs'
        ]);
        $salesRole->givePermissionTo([
            'dashboard',
            'profile',
            'categories',
            'crm/special-contact',
            'crm/contact',
            'products/create',
            'products',
            'products edit',
            'orders/create',
            'orders',
            'orders/unpaid',
            'orders show',
            'purchases',
            'purchases/create',
            'purchases/open',
            'purchases/confirmed',
            'purchases show',
            'purchases edit',
            'inventory',
            'inventory/stockin',
            'inventory/transactions',
            'suppliers',
            'loan-products',
            'reports/sales'
        ]);
//        $operationsRole->givePermissionTo([
//            'users',
//            'dashboard',
//            'profile',
//            'categories',
//            'crm/special-contact',
//            'crm/contact',
//            'products/create',
//            'products',
//            'products/{product_id}/edit',
//            'orders/create',
//            'orders',
//            'orders/unpaid',
//            'orders/{order_id}',
//            'purchases',
//            'purchases/create',
//            'purchases/open',
//            'purchases/confirmed',
//            'purchases/{purchase_id}',
//            'purchases/{purchase_id}/edit',
//            'inventory',
//            'inventory/stockin',
//            'inventory/transactions',
//            'suppliers',
//            'loan-products',
//            'reports/sales'
//        ]);
    }
}
