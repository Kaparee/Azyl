<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\AnimalImage;
use App\Models\AnimalLike;
use App\Models\Image;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ImageAndLikeSeeder extends Seeder
{
    /** @var array<string, list<int>> */
    private const SPECIES_POOLS = [
        'Pies' => [1, 35],
        'Kot' => [36, 47],
        'Królik' => [48, 50],
    ];

    public function run(): void
    {
        $faker = Faker::create('pl_PL');
        $animals = Animal::with('breed.species')->get();
        $users = User::all();

        if ($animals->isEmpty() || $users->isEmpty()) {
            return;
        }

        $storageDir = storage_path('app/public/animals');
        if (! File::isDirectory($storageDir)) {
            File::makeDirectory($storageDir, 0755, true);
        }

        $seedDir = public_path('images/seed/animals');

        foreach ($animals as $animal) {
            if ($animal->animalImages()->exists()) {
                continue;
            }

            $sourceFile = $this->resolveSeedImage($animal, $seedDir);
            if (! $sourceFile) {
                continue;
            }

            $fileName = 'animal_'.$animal->id.'_1.jpg';
            $destPath = $storageDir.'/'.$fileName;

            if (! File::exists($destPath)) {
                File::copy($sourceFile, $destPath);
            }

            $storagePath = 'animals/'.$fileName;

            $image = Image::create([
                'animal_id' => $animal->id,
                'file_name' => $storagePath,
                'original_file_name' => basename($sourceFile),
                'file_type' => 'image/jpeg',
            ]);

            AnimalImage::create([
                'animal_id' => $animal->id,
                'image_id' => $image->id,
                'sort_order' => 1,
            ]);

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

    private function resolveSeedImage(Animal $animal, string $seedDir): ?string
    {
        $speciesName = $animal->breed?->species?->name ?? 'Pies';
        $pool = self::SPECIES_POOLS[$speciesName] ?? self::SPECIES_POOLS['Pies'];
        [$min, $max] = $pool;

        $poolSize = $max - $min + 1;
        $index = $min + (($animal->id - 1) % $poolSize);
        $seedFile = $seedDir.'/'.str_pad((string) $index, 3, '0', STR_PAD_LEFT).'.jpg';

        if (File::exists($seedFile)) {
            return $seedFile;
        }

        // fallback: dowolny dostępny plik z puli 001-050
        for ($i = 1; $i <= 50; $i++) {
            $fallback = $seedDir.'/'.str_pad((string) $i, 3, '0', STR_PAD_LEFT).'.jpg';
            if (File::exists($fallback)) {
                return $fallback;
            }
        }

        return null;
    }
}
