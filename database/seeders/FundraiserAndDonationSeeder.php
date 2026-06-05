<?php

namespace Database\Seeders;

use App\Models\Fundraiser;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class FundraiserAndDonationSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('pl_PL');
        $users = User::all();
        $animals = \App\Models\Animal::all();

        if ($animals->isEmpty()) return;

        foreach (range(1, 20) as $i) {
            $goal = $faker->randomFloat(2, 500, 5000);
            $current = $faker->randomFloat(2, 50, $goal);
            $randomFundraiserDate = $faker->dateTimeBetween('-12 months', 'now');
            
            $fundraiser = Fundraiser::create([
                'animal_id' => $animals->random()->id,
                'title' => $faker->sentence(4),
                'description' => $faker->realText(300),
                'target_amount' => $goal,
                'collected_amount' => $current,
                'qr_token' => \Illuminate\Support\Str::random(10),
                'status' => $faker->numberBetween(0, 1),
                'end_date' => clone $randomFundraiserDate,
                'created_at' => $randomFundraiserDate,
                'updated_at' => $randomFundraiserDate,
            ]);

            // Add some donations
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
