<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default roles
        $adminRole = \App\Models\Role::create([
            'name' => 'Administrator',
            'description' => 'Pełny dostęp do systemu CMS/ERP.'
        ]);

        $volunteerRole = \App\Models\Role::create([
            'name' => 'Wolontariusz',
            'description' => 'Zarządzanie katalogiem zwierząt i zadaniami.'
        ]);

        $adopterRole = \App\Models\Role::create([
            'name' => 'Adoptujący',
            'description' => 'Użytkownik przeglądający katalog i składający wnioski.'
        ]);

        // Create a default admin user
        \App\Models\User::factory()->create([
            'name' => 'Admin Kuba',
            'email' => 'admin@azyl.pl',
            'password' => bcrypt('password'),
            'role_id' => $adminRole->id,
        ]);
    }
}
