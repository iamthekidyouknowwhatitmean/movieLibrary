<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Films;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WatchedTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $film;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->film = Films::factory()->create();
        $this->actingAs($this->user);
    }
    /**
     * A basic feature test example.
     */
    public function test_it_can_add_film_to_watched(): void
    {
        $response = $this->postJson('/api/watched/' . $this->film->id);

        $response->assertStatus(200)
                ->assertJson([
                    'message' => 'success',
                ],200);

        $this->assertDatabaseHas('watched', [
            'user_id' => $this->user->id,
            'films_id' => $this->film->id,
        ]);
    }

    public function test_it_can_destroy_film_from_watched()
    {
        $response = $this->deleteJson('/api/watched/' . $this->film->id);

        $response->assertStatus(200)
                ->assertJson([
                    'message' => 'success',
                ],200);

        $this->assertDatabaseMissing('watched', [
            'user_id' => $this->user->id,
            'films_id' => $this->film->id,
        ]);
    }
}
