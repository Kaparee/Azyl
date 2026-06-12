<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\User;
use App\Models\VolunteerTask;
use Faker\Factory;
use Illuminate\Database\Seeder;

class VolunteerTaskSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create('pl_PL');
        $users = User::all();

        $tasksTemplates = [
            ['title' => 'Wyprowadzenie na spacer', 'desc' => 'Długi spacer z psem, potrzebny wybieg'],
            ['title' => 'Sprzątanie boksów', 'desc' => 'Konieczne dokładne umycie i dezynfekcja klatek'],
            ['title' => 'Podanie leków', 'desc' => 'Zgodnie z rozpiską od weterynarza'],
            ['title' => 'Socjalizacja kotów', 'desc' => 'Czas spędzony w kociarni, zabawa wędką'],
            ['title' => 'Transport do weta', 'desc' => 'Wizyta kontrolna w klinice'],
            ['title' => 'Mycie misek', 'desc' => 'Poranne mycie misek po śniadaniu'],
            ['title' => 'Wyczesywanie', 'desc' => 'Pielęgnacja sierści psów z dłuższą okrywą'],
            ['title' => 'Odpisywanie na wiadomości', 'desc' => 'Pomoc biurowa, maile od chętnych do adopcji'],
        ];

        $animals = Animal::all();

        foreach (range(1, 40) as $i) {
            $template = $faker->randomElement($tasksTemplates);
            $randomDate = $faker->dateTimeBetween('-2 days', '+7 days')->format('Y-m-d');
            $randomTime = $faker->dateTimeBetween('10:00:00', '18:00:00')->format('H:i:s');

            $animalName = $animals->isNotEmpty() ? $animals->random()->name : $faker->firstName();

            VolunteerTask::create([
                'title' => $template['title'].' - '.$animalName,
                'description' => $template['desc'].'. Bardzo prosimy o rzetelne wykonanie tego zadania i odznaczenie w systemie po ukończeniu.',
                'date' => $randomDate,
                'time' => $randomTime,
                'status' => $faker->randomElement([1, 2, 3]),
                'assigned_to' => $users->random()->id,
            ]);
        }
    }
}
