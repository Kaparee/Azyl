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

        $petNames = [
            'Burek', 'Reksio', 'Mruczek', 'Puszek', 'Łatek', 'Azor', 'Kropka', 'Pusia', 'Luna', 'Klakier',
            'Szarik', 'Czaruś', 'Misiek', 'Dżok', 'Maks', 'Kajtek', 'Tośka', 'Bąbel', 'Ruda', 'Zuzia',
            'Fafik', 'Tofik', 'Fiona', 'Leo', 'Bruno', 'Simba', 'Bella', 'Rocky', 'Borys', 'Koko',
            'Figo', 'Gacek', 'Drops', 'Nela', 'Sonia', 'Karmel', 'Ciapek', 'Lola', 'Bary', 'Oreo',
            'Ares', 'Hektor', 'Pimpek', 'Fuks', 'Gryf', 'Tysia', 'Mika', 'Baster', 'Demon', 'Zefir'
        ];

        // Wygeneruj 50 zwierząt
        foreach (range(0, 49) as $i) {
            $randomDate = $faker->dateTimeBetween('-12 months', 'now');
            
            Animal::create([
                'name' => $petNames[$i],
                'breed_id' => $breeds[array_rand($breeds)]->id,
                'age_months' => $faker->numberBetween(1, 120),
                'genders' => $faker->randomElement([0, 1]),
                'height' => $faker->numberBetween(20, 80),
                'color' => $faker->colorName(),
                'description' => 'To jest wspaniały zwierzak, który szuka kochającego domu. Bardzo lubi kontakt z człowiekiem, jest ufny i przyjacielsko nastawiony do otoczenia. Czeka na kogoś, kto da mu szansę na nowe, lepsze życie.',
                'status' => $faker->randomElement([0, 1, 2, 3]), // np. 0: kwarantanna, 1: do adopcji
                'qr_token' => Str::random(10),
                'arrival_date' => $randomDate,
                'created_at' => $randomDate,
                'updated_at' => $randomDate,
            ]);
        }
    }
}
