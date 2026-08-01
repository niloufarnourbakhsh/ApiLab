<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class RegisterUserByAdminTest extends TestCase
{
    public function test_authentication()
    {
        $this->postJson('/api/users',[
            'email'=>'',
            'password'=>12345678
        ])->assertStatus(401);
    }

    public function test_authorization()
    {
        $user=User::factory()->create([
            'name'=>'niloufar',
            'email'=>'niloufar@gmail.com',
            'password'=>bcrypt(12345678)
        ]);
        $this->actingAs($user)->postJson('/api/users',[
            'email'=>'',
            'password'=>12345678
        ])->assertStatus(403);
    }

    public function test_login_validation()
    {
        $this->seed(UserSeeder::class);
        $this->post('/api/login',[
            'email'=>'',
            'password'=>12345678
        ])->assertStatus(422);
    }
    public function test_an_admin_can_add_new_user()
    {
        $this->seed();
        $admin=User::where('email','Admin@gmail.com')->first();
        $response=$this->actingAs($admin)->postJson('/api/users',[
            'name'=>'test',
            'email'=>'test@gmail.com',
            'password'=>12345678
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure(['message']);
        $response->assertJson(['message'=>'user Created successfully']);
        $registeredUser=User::findOrFail($response->json('data')['id']);
        $this->assertEquals($registeredUser->email,'test@gmail.com');
    }

}
