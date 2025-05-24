<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Create basic roles
        DB::table('roles')->insert([
            [
                'name' => 'admin',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'driver',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'customer',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'manager',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Create basic permissions
        $permissions = [
            'manage-users',
            'manage-products',
            'manage-orders',
            'manage-drivers',
            'view-reports',
            'manage-settings',
            'view-assigned-orders',
            'update-order-status',
            'view-delivery-history',
            'update-availability',
            'place-orders',
            'view-own-orders',
            'track-orders',
            'rate-orders',
            'hold_products',
            'manage-customer-credits'
        ];

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert([
                'name' => $permission,
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down()
    {
        DB::table('permissions')->whereIn('name', [
            'manage-users',
            'manage-products',
            'manage-orders',
            'manage-drivers',
            'view-reports',
            'manage-settings',
            'view-assigned-orders',
            'update-order-status',
            'view-delivery-history',
            'update-availability',
            'place-orders',
            'view-own-orders',
            'track-orders',
            'rate-orders',
            'hold_products',
            'manage-customer-credits'
        ])->delete();

        DB::table('roles')->whereIn('name', ['admin', 'driver', 'customer', 'manager'])->delete();
    }
};
