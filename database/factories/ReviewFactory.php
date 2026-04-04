<?php

namespace Database\Factories;

use App\Models\Film;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'body' => $this->faker->optional()->paragraph,
            'likes' => $this->faker->numberBetween(0, 1000),
            'rating' => $this->faker->optional()->numberBetween(0, 5),
            'film_id' => Film::factory(),
            'user_id' => User::factory(),
        ];
    }
}
