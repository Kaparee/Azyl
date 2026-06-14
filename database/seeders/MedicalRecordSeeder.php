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

        $outcomes = [
            'Pacjent zniósł zabieg bez powikłań i wrócił do boksu w dobrym stanie.',
            'Wymagana obserwacja przez 48 godzin — personel monitoruje apetyt i zachowanie.',
            'Zalecono kontrolę za tydzień oraz ograniczenie aktywności na wybiegu.',
            'Wyniki badań w normie, zwierzę może wrócić do standardowej opieki.',
            'Po podaniu leków stan się poprawił, kontynuujemy kurację zgodnie z zaleceniami.',
            'Zabieg przebiegł prawidłowo, rana goi się zgodnie z planem leczenia.',
            'Zalecono zmianę karmy i suplementację przez najbliższe 14 dni.',
            'Pacjent spokojny po zabiegu, bez oznak bólu podczas ostatniej wizyty.',
        ];

        foreach ($animals as $animal) {
            $numRecords = $faker->numberBetween(1, 4);

            for ($i = 0; $i < $numRecords; $i++) {
                $type = $faker->randomElement(array_keys($treatments));
                $procedure = $faker->randomElement($treatments[$type]);

                MedicalRecord::create([
                    'animal_id' => $animal->id,
                    'treatment_type' => $type,
                    'description' => sprintf(
                        '%s u %s — %s %s',
                        $procedure,
                        $animal->name,
                        $faker->randomElement($outcomes),
                        $faker->sentence(5)
                    ),
                    'cost' => $faker->randomFloat(2, 20, 500),
                    'treatment_date' => $faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d H:i:s'),
                ]);
            }
        }
    }
}
