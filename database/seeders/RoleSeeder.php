<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run()
    // {
    //     Role::create(['name' => 'admin']);
    //     Role::create(['name' => 'hotel_owner']);
    //     Role::create(['name' => 'customer']);
    // }


    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $admin = Role::create(['name' => 'admin']);
        $hotelOwner = Role::create(['name' => 'hotel_owner']);
        $customer = Role::create(['name' => 'customer']);

        // Define permissions
        Permission::create(['name' => 'manage hotels']);
        Permission::create(['name' => 'manage rooms']);
        Permission::create(['name' => 'manage bookings']);
        Permission::create(['name' => 'approve hotels']);

        // Assign permissions to roles
        $admin->givePermissionTo(['manage hotels', 'manage rooms', 'manage bookings', 'approve hotels']);
        $hotelOwner->givePermissionTo(['manage rooms', 'manage bookings']);
    }

}
