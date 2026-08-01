<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\UserService;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function Laravel\Prompts\password;

class LoginToAdminPanelTest extends TestCase
{

    public function test_an_admin_can_login_to_admin_panel_with_correct_data()
    {
        $this->seed(UserSeeder::class);
        $this->post('/api/login',[
            'email'=>'Admin@gmail.com',
            'password'=>12345678
        ])->assertStatus(200)
        ->assertJsonStructure(['token','name']);
    }

    public function test_an_admin_can_not_login_to_admin_panel_with_wrong_data()
    {
        $this->seed(UserSeeder::class);
        $this->post('/api/login',[
            'email'=>'Admin@gmail.com',
            'password'=>123456
        ])->assertStatus(401);
    }

}
