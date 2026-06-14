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

        $descriptionIntros = [
            'Zebrane środki pozwolą nam zapewnić %s natychmiastową opiekę weterynaryjną.',
            'Ta zbiórka jest kluczowa dla %s — każda wpłata realnie zmienia jego codzienność.',
            'Dzięki Waszemu wsparciu %s szybciej wróci do formy i będzie gotowy na adopcję.',
            'Pilnie zbieramy fundusze, aby %s mógł przejść niezbędne leczenie bez opóźnień.',
            'Wspólnie możemy zapewnić %s komfort, bezpieczeństwo i profesjonalną opiekę.',
        ];

        $descriptionDetails = [
            'Plan obejmuje konsultację specjalisty, zakup leków oraz materiałów opatrunkowych.',
            'Część środków przeznaczymy na rehabilitację i dodatkowe badania kontrolne.',
            'Fundusze pokryją transport do kliniki, nocleg po zabiegu i karmę rekonwalescencyjną.',
            'Zakupimy sprzęt rehabilitacyjny oraz zapewnimy codzienną opiekę wolontariuszy.',
            'Środki umożliwią też aktualizację dokumentacji medycznej i profilaktykę.',
            'W ramach zbiórki zadbamy o środki czystości, legowisko i suplementy diety.',
        ];

        $fundraiserAnimals = $animals->random(30);

        foreach ($fundraiserAnimals as $animal) {
            $goal = $faker->randomFloat(2, 500, 5000);
            $status = $faker->randomElement([0, 1]);

            $current = $status === 1 ? $goal : $faker->randomFloat(2, 50, $goal - 10);

            $randomFundraiserDate = $faker->dateTimeBetween('-12 months', 'now');
            $titleBase = $faker->randomElement($titles);

            $description = sprintf(
                '%s %s %s',
                sprintf($faker->randomElement($descriptionIntros), $animal->name),
                $faker->randomElement($descriptionDetails),
                $faker->sentence(8)
            );

            $fundraiser = Fundraiser::create([
                'animal_id' => $animal->id,
                'title' => $titleBase.' - '.$animal->name,
                'description' => $description,
                'target_amount' => $goal,
                'collected_amount' => $current,
                'qr_token' => Str::random(10),
                'status' => $status,
                'end_date' => $status === 1 ? clone $randomFundraiserDate : $faker->dateTimeBetween('now', '+3 months'),
                'created_at' => $randomFundraiserDate,
                'updated_at' => $randomFundraiserDate,
            ]);

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
