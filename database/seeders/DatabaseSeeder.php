<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = \App\Models\Role::firstOrCreate(['name' => 'Admin'], [
            'description' => 'Pełny dostęp do systemu CMS/ERP.'
        ]);

        $vetRole = \App\Models\Role::firstOrCreate(['name' => 'Weterynarz'], [
            'description' => 'Zarządzanie kartotekami medycznymi.'
        ]);

        $workerRole = \App\Models\Role::firstOrCreate(['name' => 'Pracownik'], [
            'description' => 'Zarządzanie operacyjne schroniskiem.'
        ]);

        $volunteerRole = \App\Models\Role::firstOrCreate(['name' => 'Wolontariusz'], [
            'description' => 'Zarządzanie katalogiem zwierząt i zadaniami.'
        ]);

        $adopterRole = \App\Models\Role::firstOrCreate(['name' => 'Adoptujący'], [
            'description' => 'Użytkownik przeglądający katalog i składający wnioski.'
        ]);

        \App\Models\User::firstOrCreate(['email' => 'admin@azyl.pl'], [
            'name' => 'Admin Kuba',
            'password' => bcrypt('password'),
            'role_id' => $adminRole->id,
        ]);

        \App\Models\User::firstOrCreate(['email' => 'weterynarz@azyl.pl'], [
            'name' => 'Maria Wiśniewska',
            'password' => bcrypt('password'),
            'role_id' => $vetRole->id,
        ]);

        \App\Models\User::firstOrCreate(['email' => 'pracownik@azyl.pl'], [
            'name' => 'Pracownik Tomek',
            'password' => bcrypt('password'),
            'role_id' => $workerRole->id,
        ]);

        \App\Models\User::firstOrCreate(['email' => 'wolontariusz@azyl.pl'], [
            'name' => 'Wolontariusz Ania',
            'password' => bcrypt('password'),
            'role_id' => $volunteerRole->id,
        ]);

        \App\Models\User::firstOrCreate(['email' => 'adoptujacy@azyl.pl'], [
            'name' => 'Jan Kowalski',
            'password' => bcrypt('password'),
            'role_id' => $adopterRole->id,
        ]);

        $this->call([
            AnimalSeeder::class,
            MedicalRecordSeeder::class,
            VolunteerTaskSeeder::class,
            AdoptionApplicationSeeder::class,
            FundraiserAndDonationSeeder::class,
            ImageAndLikeSeeder::class,
        ]);
    }
}
