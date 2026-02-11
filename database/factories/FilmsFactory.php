<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Films>
 */
class FilmsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tmdb_id'       => $this->faker->unique()->numberBetween(1, 9999999),
            'category'      => $this->faker->randomElement(['popular', 'top_rated', 'upcoming', 'now_playing']),
            'title'         => $this->faker->sentence(3),
            'release_date'  => $this->faker->optional()->date(),
            'poster_path'   => $this->faker->optional()->imageUrl(),
            'backdrop_path' => $this->faker->optional()->imageUrl(),
            'overview'      => $this->faker->optional()->paragraph(),
            'adult'         => $this->faker->boolean(10),
            'popularity'    => $this->faker->randomFloat(2, 0, 10000),
            'vote_average'  => $this->faker->randomFloat(1, 0, 10),
            'vote_count'    => $this->faker->randomFloat(0, 0, 10000),
        ];
    }
}
