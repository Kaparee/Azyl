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
        $dogSpecies = Species::create(['name' => 'Pies']);
        $catSpecies = Species::create(['name' => 'Kot']);
        $rabbitSpecies = Species::create(['name' => 'Królik']);

        $labrador = Breed::create(['species_id' => $dogSpecies->id, 'name' => 'Labrador Retriever']);
        $borderCollie = Breed::create(['species_id' => $dogSpecies->id, 'name' => 'Border Collie']);
        $husky = Breed::create(['species_id' => $dogSpecies->id, 'name' => 'Husky Syberyjski']);
        $golden = Breed::create(['species_id' => $dogSpecies->id, 'name' => 'Golden Retriever']);
        $euCat = Breed::create(['species_id' => $catSpecies->id, 'name' => 'Europejska']);
        $euCatMix = Breed::create(['species_id' => $catSpecies->id, 'name' => 'Europejska mieszaniec']);
        $rabbitMin = Breed::create(['species_id' => $rabbitSpecies->id, 'name' => 'Królik miniaturowy']);

        Animal::create([
            'name' => 'Max', 'breed_id' => $labrador->id, 'age_months' => 36, 'genders' => 0,
            'height' => 50, 'color' => 'Biszkoptowy', 'description' => 'Spokojny labrador',
            'status' => 1, 'qr_token' => Str::random(10), 'arrival_date' => now()->subMonths(2)
        ]);

        Animal::create([
            'name' => 'Luna', 'breed_id' => $borderCollie->id, 'age_months' => 24, 'genders' => 1,
            'height' => 45, 'color' => 'Czarno-biały', 'description' => 'Aktywna i wesoła',
            'status' => 1, 'qr_token' => Str::random(10), 'arrival_date' => now()->subMonths(1)
        ]);

        Animal::create([
            'name' => 'Misia', 'breed_id' => $euCatMix->id, 'age_months' => 60, 'genders' => 1,
            'height' => 25, 'color' => 'Buro-biały', 'description' => 'Puchata kulka',
            'status' => 1, 'qr_token' => Str::random(10), 'arrival_date' => now()->subMonths(5)
        ]);

        Animal::create([
            'name' => 'Rudo', 'breed_id' => $euCat->id, 'age_months' => 12, 'genders' => 0,
            'height' => 22, 'color' => 'Rudy', 'description' => 'Młody i szalony',
            'status' => 1, 'qr_token' => Str::random(10), 'arrival_date' => now()->subDays(10)
        ]);

        Animal::create([
            'name' => 'Bolt', 'breed_id' => $husky->id, 'age_months' => 48, 'genders' => 0,
            'height' => 60, 'color' => 'Szaro-biały', 'description' => 'Uwielbia bieganie',
            'status' => 1, 'qr_token' => Str::random(10), 'arrival_date' => now()->subMonths(3)
        ]);

        Animal::create([
            'name' => 'Cleo', 'breed_id' => $euCat->id, 'age_months' => 36, 'genders' => 1,
            'height' => 24, 'color' => 'Czarny', 'description' => 'Lubi głaskanie',
            'status' => 1, 'qr_token' => Str::random(10), 'arrival_date' => now()->subDays(15)
        ]);

        Animal::create([
            'name' => 'Kruszynka', 'breed_id' => $rabbitMin->id, 'age_months' => 24, 'genders' => 1,
            'height' => 15, 'color' => 'Biały', 'description' => 'Mała i słodka',
            'status' => 1, 'qr_token' => Str::random(10), 'arrival_date' => now()->subDays(5)
        ]);

        Animal::create([
            'name' => 'Zeus', 'breed_id' => $golden->id, 'age_months' => 84, 'genders' => 0,
            'height' => 55, 'color' => 'Złoty', 'description' => 'Spokojny senior',
            'status' => 1, 'qr_token' => Str::random(10), 'arrival_date' => now()->subMonths(6)
        ]);
    }
}
