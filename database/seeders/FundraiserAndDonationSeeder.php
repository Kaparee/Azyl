<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\Donation;
use App\Models\Fundraiser;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FundraiserAndDonationSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('pl_PL');
        $users = User::all();
        $animals = Animal::all();

        if ($animals->isEmpty()) {
            return;
        }

        $titles = [
            'Pilna operacja łapy',
            'Karma weterynaryjna dla kotów',
            'Nowy wybieg',
            'Leczenie zębów',
            'Ratujemy wzrok',
            'Transport zwierząt z interwencji',
            'Leki przeciwbólowe',
            'Budowa nowych bud',
            'Specjalistyczne badania',
            'Ratunek po wypadku',
            'Wsparcie dla kocich maluchów',
            'Kupno karmy gastro',
        ];

        $fundraiserAnimals = $animals->random(30); // 30 losowych zwierząt otrzyma zbiórki

        foreach ($fundraiserAnimals as $animal) {
            $goal = $faker->randomFloat(2, 500, 5000);
            $status = $faker->randomElement([0, 1]); // 0: w trakcie, 1: zakończona

            // Jeśli zakończona, kwota musi być osiągnięta lub bliska
            $current = $status === 1 ? $goal : $faker->randomFloat(2, 50, $goal - 10);

            $randomFundraiserDate = $faker->dateTimeBetween('-12 months', 'now');

            $fundraiser = Fundraiser::create([
                'animal_id' => $animal->id,
                'title' => $faker->randomElement($titles).' - '.$animal->name,
                'description' => 'To jest zbiórka dedykowana na ratowanie zdrowia i poprawę warunków życia tego wspaniałego zwierzaka. Zebrane środki zostaną w całości przeznaczone na leczenie, rehabilitację oraz zakup niezbędnej, specjalistycznej karmy i leków. Każda, nawet najdrobniejsza wpłata, ogromnie przybliża nas do osiągnięcia celu i sprawia, że szanse na szczęśliwe życie rosną.',
                'target_amount' => $goal,
                'collected_amount' => $current,
                'qr_token' => Str::random(10),
                'status' => $status,
                'end_date' => $status === 1 ? clone $randomFundraiserDate : $faker->dateTimeBetween('now', '+3 months'),
                'created_at' => $randomFundraiserDate,
                'updated_at' => $randomFundraiserDate,
            ]);

            // Dodaj darowizny, by złożyć kwotę
            $numDonations = $faker->numberBetween(10, 50);
            foreach (range(1, $numDonations) as $j) {
                $randomDonationDate = $faker->dateTimeBetween($randomFundraiserDate->format('Y-m-d H:i:s'), 'now');
                Donation::create([
                    'fundraiser_id' => $fundraiser->id,
                    'user_id' => $faker->boolean(70) ? $users->random()->id : null,
                    'amount' => $faker->randomFloat(2, 10, 200),
                    'created_at' => $randomDonationDate,
                    'updated_at' => $randomDonationDate,
                ]);
            }
        }
    }
}
