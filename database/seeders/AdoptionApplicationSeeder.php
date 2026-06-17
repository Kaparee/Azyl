<?php

namespace Database\Seeders;

use App\Enums\AdoptionStatus;
use App\Enums\AnimalStatus;
use App\Models\AdoptionApplication;
use App\Models\Animal;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class AdoptionApplicationSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('pl_PL');
        $users = User::whereIn('role_id', [4, 5])->get();
        $animals = Animal::where('status', AnimalStatus::AVAILABLE)->get();

        if ($users->isEmpty() || $animals->isEmpty()) {
            return;
        }

        $messageOpenings = [
            'Chcielibyśmy zapewnić temu zwierzakowi dom pełen ciepła i bezpieczeństwa.',
            'Szukamy towarzysza do naszej rodziny, który będzie traktowany jak członek domowników.',
            'Mamy doświadczenie w opiece nad zwierzętami ze schroniska i jesteśmy gotowi na adopcję.',
            'Po długich rozmowach zdecydowaliśmy się złożyć wniosek — czujemy, że to dobre dopasowanie.',
            'Mieszkamy w spokojnej okolicy i możemy poświęcić zwierzęciu dużo czasu każdego dnia.',
            'Pracuję zdalnie, więc pupil nie będzie zostawał sam na długie godziny.',
            'Mamy zabezpieczone okna i balkon — dbamy o bezpieczeństwo kota w mieszkaniu.',
            'Dzieci w naszym domu dorastały z psem i wiedzą, jak delikatnie obchodzić się ze zwierzętami.',
        ];

        $messageDetails = [
            'Prosimy o rozpatrzenie wniosku i kontakt w celu spotkania zapoznawczego.',
            'Jesteśmy otwarci na wizytę pracownika schroniska w naszym domu.',
            'Możemy przyjechać na spotkanie z zwierzęciem w dogodnym dla Państwa terminie.',
            'W razie potrzeby skorzystamy z pomocy behawiorysty w okresie adaptacji.',
            'Zapewnimy stałą opiekę weterynaryjną i odpowiednią dietę.',
            'W domu mamy ogród ogrodzony — idealny do spacerów i zabawy.',
            'Poprzedni pupil żył u nas 12 lat — wiemy, czym jest odpowiedzialna adopcja.',
            'Chętnie podejmiemy się dodatkowych zaleceń ze strony schroniska.',
        ];

        $approvedAnimals = $animals->shuffle()->take(min(18, $animals->count()));
        foreach ($approvedAnimals as $animal) {
            $approvedAt = Carbon::now()
                ->subMonths($faker->numberBetween(0, 11))
                ->day($faker->numberBetween(1, 28));
            $createdAt = (clone $approvedAt)->subDays($faker->numberBetween(3, 21));

            $userId = $users->random()->id;
            AdoptionApplication::firstOrCreate(
                [
                    'user_id' => $userId,
                    'animal_id' => $animal->id,
                ],
                [
                    'status' => AdoptionStatus::APPROVED,
                    'message' => sprintf(
                        'Wniosek o adopcję %s. %s %s %s',
                        $animal->name,
                        $faker->randomElement($messageOpenings),
                        $faker->randomElement($messageDetails),
                        $faker->sentence(7)
                    ),
                    'created_at' => $createdAt,
                    'updated_at' => $approvedAt,
                ]
            );

            $animal->update(['status' => AnimalStatus::ADOPTED]);
        }

        $remaining = Animal::where('status', AnimalStatus::AVAILABLE)->get();
        $targetAnimals = $remaining->random(min(12, $remaining->count()));

        foreach ($targetAnimals as $animal) {
            $status = $faker->randomElement([
                AdoptionStatus::PENDING,
                AdoptionStatus::PENDING,
                AdoptionStatus::REJECTED,
            ]);

            $randomDate = $faker->dateTimeBetween('-3 months', 'now');

            AdoptionApplication::firstOrCreate(
                [
                    'user_id' => $users->random()->id,
                    'animal_id' => $animal->id,
                ],
                [
                    'status' => $status,
                    'message' => sprintf(
                        'Wniosek o adopcję %s. %s %s %s',
                        $animal->name,
                        $faker->randomElement($messageOpenings),
                        $faker->randomElement($messageDetails),
                        $faker->sentence(7)
                    ),
                    'created_at' => $randomDate,
                    'updated_at' => $randomDate,
                ]
            );

            if ($status === AdoptionStatus::PENDING) {
                $animal->update(['status' => AnimalStatus::PENDING]);
            }
        }
    }
}
