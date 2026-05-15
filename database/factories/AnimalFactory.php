<?php

namespace Database\Factories;

use App\Enums\AnimalStatus;
use App\Models\Breed;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Animal>
 */
class AnimalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->firstName(),
            'breed_id' => Breed::factory(),
            'age_months' => fake()->numberBetween(1, 120),
            'genders' => fake()->randomElement([0, 1]), // 0 Male, 1 Female
            'height' => fake()->numberBetween(20, 80),
            'color' => fake()->colorName(),
            'description' => fake()->paragraph(),
            'medical_info' => fake()->sentence(),
            'adoption_fee' => fake()->randomFloat(2, 0, 500),
            'status' => AnimalStatus::AVAILABLE,
            'qr_token' => Str::random(10),
            'arrival_date' => now(),
            'click_count' => 0,
        ];
    }
}
