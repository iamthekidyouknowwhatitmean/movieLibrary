<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use App\Mail\Welcome;
use Illuminate\Support\Facades\Hash;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register(){
        Mail::fake();

        $response = $this->postJson('/api/register', [
            'username' => 'johndoe',
            'email' => 'john@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
        ]);

        $user = User::first();

        $this->assertTrue(
            Hash::check('password', $user->password)
        );

        Mail::assertQueued(Welcome::class,function(Welcome $mail){
            return $mail->hasSubject('Welcome');
        });
    }

    public function test_user_cannot_register_with_existing_email()
    {
        User::factory()->create([
            'email' => 'john@example.com',
        ]);

        $response = $this->postJson('/api/register', [
            'username' => 'johndoe',
            'email' => 'john@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_registration_requires_valid_data()
    {
        $response = $this->postJson('/api/register', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'email',
            'username',
            'password',
        ]);
    }
}
