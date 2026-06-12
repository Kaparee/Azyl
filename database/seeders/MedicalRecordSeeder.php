<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\MedicalRecord;
use Faker\Factory;
use Illuminate\Database\Seeder;

class MedicalRecordSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create('pl_PL');
        $animals = Animal::inRandomOrder()->take(50)->get();

        $treatments = [
            'Szczepienie' => ['Wścieklizna', 'Zakaźne', 'Nosówka'],
            'Badanie' => ['Morfologia', 'USG jamy brzusznej', 'RTG klatki piersiowej', 'Badanie kliniczne'],
            'Zabieg' => ['Kastracja', 'Czyszczenie zębów', 'Szycie rany'],
            'Leki' => ['Antybiotyk', 'Leki przeciwbólowe', 'Krople do oczu', 'Maść na grzybicę'],
            'Odrobaczanie' => ['Tabletka', 'Krople spot-on'],
            'Profilaktyka' => ['Zabezpieczenie na kleszcze', 'Obcięcie pazurów'],
        ];

        foreach ($animals as $animal) {
            $numRecords = $faker->numberBetween(1, 4);

            for ($i = 0; $i < $numRecords; $i++) {
                $type = $faker->randomElement(array_keys($treatments));
                $descTemplate = $faker->randomElement($treatments[$type]);

                MedicalRecord::create([
                    'animal_id' => $animal->id,
                    'treatment_type' => $type,
                    'description' => $descTemplate.' (Zabieg przeprowadzony w klinice weterynaryjnej, pacjent zniósł dobrze).',
                    'cost' => $faker->randomFloat(2, 20, 500),
                    'treatment_date' => $faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d H:i:s'),
                ]);
            }
        }
    }
}
