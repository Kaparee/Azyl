<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\AnimalClick;
use Faker\Factory;
use Illuminate\Database\Seeder;

class AnimalClickSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create('pl_PL');
        $animals = Animal::pluck('id');

        if ($animals->isEmpty()) {
            return;
        }

        foreach ($animals->random(min(15, $animals->count())) as $animalId) {
            foreach (range(1, $faker->numberBetween(3, 20)) as $i) {
                AnimalClick::create([
                    'animal_id' => $animalId,
                    'clicked_at' => $faker->dateTimeBetween('-29 days', 'now'),
                ]);
            }
        }
    }
}
