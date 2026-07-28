<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::factory()->state([
            'name'=>'read_user',
            'display_name'=>'read_user'
        ])->create();
        Permission::factory()->state([
            'name'=>'create_user',
            'display_name'=>'create_user'
        ])->create();
        Permission::factory()->state([
            'name'=>'update_user',
            'display_name'=>'update_user'
        ])->create();
        Permission::factory()->state([
            'name'=>'delete_user',
            'display_name'=>'delete_user'
        ])->create();
    }
}
