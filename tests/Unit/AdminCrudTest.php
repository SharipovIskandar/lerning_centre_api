<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;

class AdminCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_creation()
    {
        $admin = User::factory()->create();
        $this->assertDatabaseHas('users', [
            'password' => $admin->password,
        ]);
    }

    public function test_admin_update()
    {
        $admin = User::factory()->create();
        $admin->update(['first_name' => 'Updated Admin']);
        $this->assertEquals('Updated Admin', $admin->fresh()->first_name);
    }

    public function test_admin_deletion()
    {
        $admin = User::factory()->create();
        $admin->delete();
        $this->assertDatabaseMissing('users', ['id' => $admin->id]);
    }
}

