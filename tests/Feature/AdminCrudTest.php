<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class AdminCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_index()
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'admin', 'key' => 'admin']);
        DB::table('user_roles')->insert(['user_id' => $user->id, 'role_id' => $role->id]);
        $response = $this->get('/api/admin');
        $response->assertStatus(200);
    }

//    public function test_admin_store()
//    {
//        $data = [
//            'first_name' => 'asdasdad',
//            'last_name' => 'asdasd',
//            'pinfl' => '53421233',
//            'email' => 'qwe.loyce@example.org',
//            'role_id' => 2,
//            'password' => 'qweqfsdr1'
//        ];
//        $response = $this->post('/api/admin', $data);
//        $response->assertStatus(201)
//            ->assertJsonFragment(['name' => 'Test Admin']);
//    }
//
//    public function test_admin_show()
//    {
//        $admin = User::factory()->create();
//        $response = $this->get("/api/admin/{$admin->id}");
//        $response->assertStatus(200)
//            ->assertJsonFragment(['id' => $admin->id]);
//    }
//
//    public function test_admin_update()
//    {
//        $admin = User::factory()->create();
//        $data = ['name' => 'Updated Admin'];
//        $response = $this->patch("/api/admin/{$admin->id}", $data);
//        $response->assertStatus(200)
//            ->assertJsonFragment(['name' => 'Updated Admin']);
//    }
//
//    public function test_admin_destroy()
//    {
//        $admin = User::factory()->create();
//        $response = $this->delete("/api/admin/{$admin->id}");
//        $response->assertStatus(204);
//    }
}

