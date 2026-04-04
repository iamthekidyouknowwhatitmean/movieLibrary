<?php

namespace Database\Factories;

use App\Models\Film;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Film>
 */
class FilmFactory extends Factory
{
    protected $model = Film::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category'      => $this->faker->randomElement(['popular', 'top_rated', 'upcoming', 'now_playing']),
            'title'         => $this->faker->sentence(3),
            'release_date'  => $this->faker->date('Y-m-d'),
            'poster_path'   => $this->faker->optional()->imageUrl(),
            'backdrop_path' => $this->faker->optional()->imageUrl(),
            'overview'      => $this->faker->text(),
            'adult'         => $this->faker->boolean(10),
            'popularity'    => $this->faker->randomFloat(2, 0, 10000),
            'vote_average'  => $this->faker->randomFloat(1, 0, 10),
            'vote_count'    => $this->faker->randomFloat(0, 0, 10000),
            'budget' => $this->faker->randomNumber(3,false),
            'revenue' => $this->faker->randomNumber(5,false),
            'runtime' => $this->faker->numberBetween(0,300),
            'status' => 'Released',
            'tagline' => $this->faker->sentence(),
        ];
    }
}
