<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Species;
use App\Models\Breed;
use App\Models\Animal;

class AnimalSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('pl_PL');

        $dogSpecies = Species::firstOrCreate(['name' => 'Pies']);
        $catSpecies = Species::firstOrCreate(['name' => 'Kot']);
        $rabbitSpecies = Species::firstOrCreate(['name' => 'Królik']);

        $breeds = [
            Breed::firstOrCreate(['species_id' => $dogSpecies->id, 'name' => 'Labrador Retriever']),
            Breed::firstOrCreate(['species_id' => $dogSpecies->id, 'name' => 'Border Collie']),
            Breed::firstOrCreate(['species_id' => $dogSpecies->id, 'name' => 'Husky Syberyjski']),
            Breed::firstOrCreate(['species_id' => $dogSpecies->id, 'name' => 'Golden Retriever']),
            Breed::firstOrCreate(['species_id' => $catSpecies->id, 'name' => 'Europejska']),
            Breed::firstOrCreate(['species_id' => $catSpecies->id, 'name' => 'Europejska mieszaniec']),
            Breed::firstOrCreate(['species_id' => $rabbitSpecies->id, 'name' => 'Królik miniaturowy']),
        ];

        // Dodaj 150 zwierząt na przestrzeni 12 miesięcy
        foreach (range(1, 150) as $i) {
            $randomDate = $faker->dateTimeBetween('-12 months', 'now');
            
            Animal::create([
                'name' => $faker->firstName(),
                'breed_id' => $breeds[array_rand($breeds)]->id,
                'age_months' => $faker->numberBetween(1, 120),
                'genders' => $faker->randomElement([0, 1]),
                'height' => $faker->numberBetween(20, 80),
                'color' => $faker->colorName(),
                'description' => $faker->realText(100),
                'status' => $faker->randomElement([0, 1, 2, 3]), // np. 0: kwarantanna, 1: do adopcji
                'qr_token' => Str::random(10),
                'arrival_date' => $randomDate,
                'created_at' => $randomDate,
                'updated_at' => $randomDate,
            ]);
        }
    }
}
