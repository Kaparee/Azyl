<?php

namespace Database\Factories;

use App\Models\Breed;
use App\Models\Species;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Breed>
 */
class BreedFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'species_id' => Species::factory(),
        ];
    }
}
