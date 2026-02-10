<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }

    public function test_admin_cannot_access_user_management()
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($user)->get('/users');

        $response->assertStatus(403);
    }

    public function test_superadmin_can_access_user_management()
    {
        $user = User::factory()->create([
            'role' => 'superadmin',
        ]);

        $response = $this->actingAs($user)->get('/users');

        $response->assertStatus(200);
    }

    public function test_superadmin_can_create_user()
    {
        $user = User::factory()->create([
            'role' => 'superadmin',
        ]);

        $response = $this->actingAs($user)->post('/users', [
            'name' => 'New Admin',
            'email' => 'newadmin@example.com',
            'role' => 'admin',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect('/users');
        $this->assertDatabaseHas('users', [
            'email' => 'newadmin@example.com',
            'role' => 'admin',
        ]);
    }
}
