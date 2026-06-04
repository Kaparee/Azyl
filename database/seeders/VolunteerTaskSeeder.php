<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VolunteerTask;
use App\Models\User;

class VolunteerTaskSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@azyl.pl')->first();
        
        if($admin) {
            VolunteerTask::create([
                'title' => 'Leki - Cleo',
                'description' => 'Amoksycylina 50mg – tabletka w karmie',
                'date' => '2025-04-24 00:00:00',
                'time' => '10:00:00',
                'status' => 3, // Wykonano
                'assigned_to' => $admin->id
            ]);

            VolunteerTask::create([
                'title' => 'Leki - Zeus',
                'description' => 'Chondroprotex + Omega-3 przy posiłku',
                'date' => '2025-04-24 00:00:00',
                'time' => '12:00:00',
                'status' => 1, // Oczekuje
                'assigned_to' => $admin->id
            ]);

            VolunteerTask::create([
                'title' => 'Kontrola - Cleo',
                'description' => 'Ocena przebiegu kwarantanny – koniec za 4 dni',
                'date' => '2025-04-24 00:00:00',
                'time' => '16:00:00',
                'status' => 1, // Oczekuje
                'assigned_to' => $admin->id
            ]);
        }
    }
}
