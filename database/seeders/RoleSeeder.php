<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Role::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Role::create(['name' => 'admin', 'guard_name' => 'api']);
        Role::create(['name' => 'fan', 'guard_name' => 'api']);
        Role::create(['name' => 'athelete', 'guard_name' => 'api']);
        Role::create(['name' => 'corsacaster', 'guard_name' => 'api', 'guard_name' => 'api']);
        Role::create(['name' => 'guest', 'guard_name' => 'api']);
    }
}
