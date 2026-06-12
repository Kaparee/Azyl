<?php

namespace Database\Seeders;

use App\Enums\AdoptionStatus;
use App\Enums\AnimalStatus;
use App\Models\AdoptionApplication;
use App\Models\Animal;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

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

        $messages = [
            'Mam duży dom z ogrodem, pracuję zdalnie, więc pies będzie miał stałą opiekę. Mieszkam z partnerem, nie mamy dzieci.',
            'Mieszkamy w bloku na parterze. Mieliśmy już wcześniej psa ze schroniska. Jesteśmy aktywną rodziną, uwielbiamy długie spacery.',
            'Zakochałam się w tym zwierzaku od pierwszego wejrzenia! Mam już jednego kota, szukam mu towarzysza.',
            'Szukamy spokojnego przyjaciela dla naszej starszej babci. Zwierzę będzie mieszkało w domu.',
            'Mam doświadczenie z trudnymi psami. Chętnie podejmę się pracy z behawiorystą jeśli będzie trzeba.',
            'Mieszkam sam w mieszkaniu 50m2. Chciałbym zaadoptować kota. Okna mam zabezpieczone siatką.',
            'Bardzo prosimy o rozpatrzenie naszego wniosku. Dzieci od dawna marzą o psie, a my jesteśmy gotowi na ten obowiązek.',
        ];

        foreach ($animals as $animal) {
            $numApplications = $faker->numberBetween(1, 3);

            for ($i = 0; $i < $numApplications; $i++) {
                $status = $faker->randomElement([AdoptionStatus::PENDING, AdoptionStatus::APPROVED, AdoptionStatus::REJECTED]);
                $randomDate = $faker->dateTimeBetween('-6 months', 'now');

                AdoptionApplication::firstOrCreate(
                    [
                        'user_id' => $users->random()->id,
                        'animal_id' => $animal->id,
                    ],
                    [
                        'status' => $status,
                        'message' => $faker->randomElement($messages),
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
}
