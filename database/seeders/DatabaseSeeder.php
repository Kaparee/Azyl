<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'Admin'], [
            'description' => 'Pełny dostęp do systemu CMS/ERP.',
        ]);

        $vetRole = Role::firstOrCreate(['name' => 'Weterynarz'], [
            'description' => 'Zarządzanie kartotekami medycznymi.',
        ]);

        $workerRole = Role::firstOrCreate(['name' => 'Pracownik'], [
            'description' => 'Zarządzanie operacyjne schroniskiem.',
        ]);

        $volunteerRole = Role::firstOrCreate(['name' => 'Wolontariusz'], [
            'description' => 'Zarządzanie katalogiem zwierząt i zadaniami.',
        ]);

        $adopterRole = Role::firstOrCreate(['name' => 'Adoptujący'], [
            'description' => 'Użytkownik przeglądający katalog i składający wnioski.',
        ]);

        User::firstOrCreate(['email' => 'admin@azyl.pl'], [
            'name' => 'Admin Kuba',
            'password' => bcrypt('password'),
            'role_id' => $adminRole->id,
        ]);

        User::firstOrCreate(['email' => 'weterynarz@azyl.pl'], [
            'name' => 'Maria Wiśniewska',
            'password' => bcrypt('password'),
            'role_id' => $vetRole->id,
        ]);

        User::firstOrCreate(['email' => 'pracownik@azyl.pl'], [
            'name' => 'Pracownik Tomek',
            'password' => bcrypt('password'),
            'role_id' => $workerRole->id,
        ]);

        User::firstOrCreate(['email' => 'wolontariusz@azyl.pl'], [
            'name' => 'Wolontariusz Ania',
            'password' => bcrypt('password'),
            'role_id' => $volunteerRole->id,
        ]);

        User::firstOrCreate(['email' => 'adoptujacy@azyl.pl'], [
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
            AnimalClickSeeder::class,
            NewsSeeder::class,
        ]);
    }
}
