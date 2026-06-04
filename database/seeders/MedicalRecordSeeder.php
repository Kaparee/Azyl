<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MedicalRecord;
use App\Models\Animal;

class MedicalRecordSeeder extends Seeder
{
    public function run(): void
    {
        $max = Animal::where('name', 'Max')->first();
        $cleo = Animal::where('name', 'Cleo')->first();
        $bolt = Animal::where('name', 'Bolt')->first();
        $luna = Animal::where('name', 'Luna')->first();
        
        if($max) {
            MedicalRecord::create([
                'animal_id' => $max->id,
                'treatment_type' => 'Szczepienie',
                'description' => 'Szczepienie roczne (Dr Maria Wiśniewska). Kontrola za rok.',
                'cost' => 180,
                'treatment_date' => '2025-04-15 10:00:00'
            ]);
            MedicalRecord::create([
                'animal_id' => $max->id,
                'treatment_type' => 'Badanie',
                'description' => 'Badanie ogólne. Kontrola zalecona.',
                'cost' => 80,
                'treatment_date' => '2025-03-10 14:00:00'
            ]);
        }

        if($cleo) {
            MedicalRecord::create([
                'animal_id' => $cleo->id,
                'treatment_type' => 'Leki',
                'description' => 'Leczenie infekcji górnych dróg oddechowych',
                'cost' => 120,
                'treatment_date' => '2025-04-10 09:00:00'
            ]);
        }

        if($bolt) {
            MedicalRecord::create([
                'animal_id' => $bolt->id,
                'treatment_type' => 'Zabieg',
                'description' => 'Kastracja',
                'cost' => 300,
                'treatment_date' => '2025-04-05 11:30:00'
            ]);
        }

        if($luna) {
            MedicalRecord::create([
                'animal_id' => $luna->id,
                'treatment_type' => 'Odrobaczanie',
                'description' => 'Tabletki na odrobaczanie',
                'cost' => 45,
                'treatment_date' => '2025-04-18 15:20:00'
            ]);
        }
    }
}
