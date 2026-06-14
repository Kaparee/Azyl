<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\VolunteerTask;
use Faker\Factory;
use Illuminate\Database\Seeder;

class VolunteerTaskSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create('pl_PL');
        $volunteers = User::where('role_id', 4)->get();
        $animals = \App\Models\Animal::all();

        if ($volunteers->isEmpty()) {
            return;
        }

        $tasksTemplates = [
            ['title' => 'Wyprowadzenie na spacer', 'desc' => 'Długi spacer z psem na wybiegu za schroniskiem'],
            ['title' => 'Sprzątanie boksów', 'desc' => 'Dokładne umycie i dezynfekcja klatek w sekcji psów'],
            ['title' => 'Podanie leków', 'desc' => 'Podanie leków zgodnie z poranną rozpiską weterynarza'],
            ['title' => 'Socjalizacja kotów', 'desc' => 'Spokojna zabawa i kontakt w kociarni'],
            ['title' => 'Transport do weta', 'desc' => 'Transport na kontrolną wizytę do kliniki partnerskiej'],
            ['title' => 'Mycie misek', 'desc' => 'Mycie i uzupełnienie misek po porannym posiłku'],
            ['title' => 'Wyczesywanie', 'desc' => 'Pielęgnacja sierści u psów z dłuższą okrywą'],
            ['title' => 'Odpisywanie na wiadomości', 'desc' => 'Pomoc biurowa — odpowiedzi na zapytania adopcyjne'],
        ];

        $taskNotes = [
            'Prosimy o zgłoszenie wykonania w systemie po zakończeniu.',
            'W razie wątpliwości skontaktuj się z opiekunem zmiany.',
            'Sprzęt znajduje się w magazynie przy wejściu do boksów.',
            'Zadanie priorytetowe dla dobrostanu zwierząt w tej sekcji.',
            'Uwaga: zwierzę może być nieco lękliwe — zachowaj spokój i cierpliwość.',
            'Po zadaniu uzupełnij krótką notatkę w planie dnia.',
            'Wymagane rękawiczki i fartuch — leżą w szafce przy recepcji.',
            'Można wykonać w parze z innym wolontariuszem.',
        ];

        foreach (range(1, 40) as $i) {
            $template = $faker->randomElement($tasksTemplates);
            $randomDate = $faker->dateTimeBetween('-2 days', '+7 days')->format('Y-m-d');
            $randomTime = $faker->dateTimeBetween('10:00:00', '18:00:00')->format('H:i:s');

            $animalName = $animals->isNotEmpty() ? $animals->random()->name : $faker->firstName();

            VolunteerTask::create([
                'title' => $template['title'].' - '.$animalName,
                'description' => sprintf(
                    '%s. Dotyczy podopiecznego: %s. %s %s',
                    $template['desc'],
                    $animalName,
                    $faker->randomElement($taskNotes),
                    $faker->sentence(6)
                ),
                'date' => $randomDate,
                'time' => $randomTime,
                'status' => $faker->randomElement([1, 2, 3]),
                'is_urgent' => $faker->boolean(20),
                'assigned_to' => $volunteers->random()->id,
            ]);
        }
    }
}
