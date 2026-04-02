<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_personal_info():void
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->postJson('/api/settings',[
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'temp@yahoo.com'
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('users', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'temp@yahoo.com'
        ]);
    }

    public function test_user_cant_update_personal_info_with_invalid_data():void
    {
        $user = User::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'temp@yahoo.com'
        ]);
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/settings',[
            'first_name' => 123,
            'last_name' => 'Doe',
            'email' => 'justtext'
        ]);

        $response->assertStatus(422);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'temp@yahoo.com'
        ]);
    }
}
