<?php

namespace Tests\Feature\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_user_can_login(): void
    {
        User::factory()->create([
            'email' => 'johndoe@gmail.com',
            'password' => Hash::make('12345678'),
            'username' => 'johnny111'
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'johndoe@gmail.com',
            'password' => '12345678',
        ]);

        $response->assertOk();

        $response->assertJsonStructure([
            'message',
            'data' => ['token'],
        ]);

        $this->assertDatabaseCount('personal_access_tokens', 1);
    }

    public function test_user_cant_login_with_invalid_credentials(): void
    {
        User::factory()->create([
            'email' => 'notjohndoe@gmail.com',
            'password' => Hash::make('password'),
            'username' => 'meggg'
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'johndoe@gmail.com',
            'password' => '12345678',
        ]);

        $response->assertStatus(401);

        $response->assertJson([
            'message' => 'Invalid credentials',
        ]);

        $this->assertDatabaseCount('personal_access_tokens', 0);
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();

        $token = $user->createToken(
                    'API token for ' . $user->email,
                    )->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/logout');

        $response->assertOk();

        $this->assertDatabaseCount('personal_access_tokens', 0);
    }
}
