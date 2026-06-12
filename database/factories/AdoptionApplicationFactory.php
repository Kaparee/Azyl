<?php

namespace Database\Factories;

use App\Enums\AdoptionStatus;
use App\Models\AdoptionApplication;
use App\Models\Animal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AdoptionApplication>
 */
class AdoptionApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'animal_id' => Animal::factory(),
            'status' => AdoptionStatus::PENDING,
            'message' => fake()->sentence(),
        ];
    }
}
