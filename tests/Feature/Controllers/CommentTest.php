<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Film;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_comment_review():void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $film = Film::factory()->create();

        $review = Review::factory()->create([
            'user_id' => $user->id,
            'film_id' => $film->id,
            'body' => 'Отличный фильм!'
        ]);

        $response = $this->postJson('/api/comment',[
            'body' => 'Согласен!',
            'review_id' => $review->id
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('comments', [
            'body' => 'Согласен!',
            'review_id' => $review->id,
            'user_id' => $user->id
        ]);
        $this->assertDatabaseHas('activities', [
            'user_id' => $user->id,
            'type' => 'comment',
            'activitable_type' => Comment::class,
            'activitable_id' => Comment::first()->id
        ]);
    }
}
