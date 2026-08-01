<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->state([
            'name'=>'Admin',
            'email'=>'Admin@gmail.com',
            'password'=>bcrypt(12345678)
        ])->create();
//        User::factory()->count(50)->create();
    }
}
