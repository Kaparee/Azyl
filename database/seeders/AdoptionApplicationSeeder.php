<?php

namespace Database\Seeders;

use App\Models\AdoptionApplication;
use App\Models\Animal;
use App\Models\User;
use App\Enums\AdoptionStatus;
use App\Enums\AnimalStatus;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AdoptionApplicationSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('pl_PL');
        $users = User::whereIn('role_id', [4, 5])->get();
        $animals = Animal::all();

        if ($users->isEmpty() || $animals->isEmpty()) {
            return;
        }

        foreach (range(1, 200) as $i) {
            $animal = $animals->random();
            $status = $faker->randomElement([AdoptionStatus::PENDING, AdoptionStatus::APPROVED, AdoptionStatus::REJECTED]);

            $randomDate = $faker->dateTimeBetween('-12 months', 'now');

            AdoptionApplication::firstOrCreate(
                [
                    'user_id' => $users->random()->id,
                    'animal_id' => $animal->id,
                ],
                [
                    'status' => $status,
                    'message' => $faker->realText(150),
                    'created_at' => $randomDate,
                    'updated_at' => $randomDate,
                ]
            );

            if ($status === AdoptionStatus::APPROVED) {
                $animal->update(['status' => AnimalStatus::ADOPTED]);
            }
        }
    }
}
