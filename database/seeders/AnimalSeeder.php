<?php

namespace Database\Seeders;

use App\Enums\AnimalStatus;
use App\Models\Animal;
use App\Models\Breed;
use App\Models\Species;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AnimalSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create('pl_PL');

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
            'Ares', 'Hektor', 'Pimpek', 'Fuks', 'Gryf', 'Tysia', 'Mika', 'Baster', 'Demon', 'Zefir',
        ];

        $personalities = [
            'spokojny i wylewny', 'energiczny i ciekawski', 'delikatny i nieco nieśmiały',
            'wesoły i towarzyski', 'inteligentny i posłuszny', 'samodzielny, ale przyjazny',
            'kochający pieszczoty', 'uwielbiający aktywność na dworze', 'idealny do spokojnego domu',
            'świetnie odnajdujący się wśród dzieci', 'wymagający cierpliwego opiekuna',
            'szybko przywiązujący się do ludzi', 'lubiący rutynę i przewidywalność',
        ];

        $arrivalReasons = [
            'znaleziony jako porzucony na obrzeżach miasta',
            'oddany przez właściciela z powodu przeprowadzki',
            'uratowany z nielegalnej hodowli',
            'przywieziony po interwencji straży miejskiej',
            'trafił do nas po wypadku komunikacyjnym',
            'został wycofany z adopcji i wrócił do schroniska',
            'znaleziony w stanie wycieńczenia przy drodze',
            'oddany, bo poprzedni opiekun nie mógł zapewnić leczenia',
        ];

        $medicalNotes = [
            'Wymaga regularnych kontroli u weterynarza.',
            'Zaszczepiony zgodnie z kalendarzem szczepień.',
            'Po kastracji — okres rekonwalescencji zakończony.',
            'Leczony na infekcję skórną, obecnie bez objawów.',
            'Wymaga specjalistycznej karmy weterynaryjnej.',
            'Ma drobne problemy stomatologiczne — zalecane czyszczenie zębów.',
            'Przeszedł odrobaczanie i badania profilaktyczne.',
            'W trakcie socjalizacji po trudnych doświadczeniach.',
            'Nadaje się do domu bez innych zwierząt.',
            'Dobrze znosi kontakt z psami, ostrożny wobec obcych.',
        ];

        foreach (range(0, 49) as $i) {
            $randomDate = $faker->dateTimeBetween('-12 months', 'now');
            $breed = $breeds[array_rand($breeds)];
            $name = $petNames[$i];

            $status = $faker->randomElement([
                AnimalStatus::AVAILABLE,
                AnimalStatus::AVAILABLE,
                AnimalStatus::AVAILABLE,
                AnimalStatus::AVAILABLE,
                AnimalStatus::PENDING,
                AnimalStatus::ADOPTED,
                AnimalStatus::UNAVAILABLE,
            ]);

            $description = sprintf(
                '%s to %s podopieczny Azylu, który %s. %s %s',
                $name,
                $faker->randomElement($personalities),
                $faker->randomElement($arrivalReasons),
                $faker->randomElement([
                    'Uwielbia długie spacery i kontakt z człowiekiem.',
                    'Najlepiej czuje się w cichym, stabilnym otoczeniu.',
                    'Szybko uczy się nowych komend i zasad w domu.',
                    'Potrzebuje opiekuna, który poświęci mu czas na zabawę.',
                    'Świetnie odnajduje się w mieszkaniu, o ile ma swoje miejsce do odpoczynku.',
                    'Szuka domu, w którym będzie traktowany jak pełnoprawny członek rodziny.',
                ]),
                $faker->randomElement([
                    'Czeka na kogoś, kto da mu drugą szansę.',
                    'Marzy o bezpiecznym kącie i codziennej miłości.',
                    'Zasługuje na cierpliwego opiekuna gotowego do adopcji.',
                    'Jest gotowy na nowy rozdział życia u boku człowieka.',
                ])
            );

            Animal::create([
                'name' => $name,
                'breed_id' => $breed->id,
                'age_months' => $faker->numberBetween(1, 120),
                'genders' => $faker->randomElement([0, 1]),
                'height' => $faker->numberBetween(20, 80),
                'color' => $faker->colorName(),
                'description' => $description,
                'medical_info' => $faker->randomElement($medicalNotes).' '.$faker->sentence(6),
                'status' => $status,
                'qr_token' => Str::random(10),
                'arrival_date' => $randomDate,
                'created_at' => $randomDate,
                'updated_at' => $randomDate,
            ]);
        }
    }
}
