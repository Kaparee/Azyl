<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\AnimalImage;
use App\Models\AnimalLike;
use App\Models\Image;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ImageAndLikeSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('pl_PL');
        $animals = Animal::all();
        $users = User::all();

        if ($animals->isEmpty() || $users->isEmpty()) {
            return;
        }

        // Add 2-3 images to each animal
        foreach ($animals as $animal) {
            $numImages = $faker->numberBetween(1, 3);
            for ($i = 1; $i <= $numImages; $i++) {
                $image = Image::create([
                    'animal_id' => $animal->id,
                    'file_name' => 'seed_'.$faker->uuid.'.jpg',
                    'original_file_name' => 'photo_'.$i.'.jpg',
                    'file_type' => 'image/jpeg',
                ]);

                AnimalImage::create([
                    'animal_id' => $animal->id,
                    'image_id' => $image->id,
                    'sort_order' => $i,
                ]);
            }

            // Add likes from random users
            $numLikes = $faker->numberBetween(0, 5);
            $randomUsers = $users->random(min($numLikes, $users->count()));
            foreach ($randomUsers as $user) {
                AnimalLike::firstOrCreate([
                    'animal_id' => $animal->id,
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}
