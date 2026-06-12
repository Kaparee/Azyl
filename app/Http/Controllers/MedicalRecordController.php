<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\MedicalRecord;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function index(Request $request)
    {
        $query = Animal::with(['breed', 'medicalRecords' => function ($q) {
            $q->orderByDesc('treatment_date');
        }]);

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        $animals = $query->paginate(15)->appends($request->query());

        return view('medical-records.index', compact('animals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'treatment_type' => 'required|string',
            'description' => 'required|string',
            'cost' => 'required|numeric',
            'treatment_date' => 'required|date',
        ]);

        MedicalRecord::create($validated);

        return back()->with('success', 'Dodano nowy wpis medyczny.');
    }

    public function update(Request $request, MedicalRecord $record)
    {
        $validated = $request->validate([
            'treatment_type' => 'required|string',
            'description' => 'required|string',
            'cost' => 'required|numeric',
            'treatment_date' => 'required|date',
        ]);

        $record->update($validated);

        return back()->with('success', 'Zaktualizowano wpis medyczny.');
    }

    public function destroy(MedicalRecord $record)
    {
        $record->delete();

        return back()->with('success', 'Usunięto wpis medyczny.');
    }

    public function exportPdf(Animal $animal)
    {
        $animal->load(['breed.species', 'medicalRecords' => function ($q) {
            $q->orderByDesc('treatment_date');
        }]);

        $pdf = Pdf::loadView('medical-records.pdf', compact('animal'));

        return $pdf->download('karta_medyczna_'.$animal->name.'.pdf');
    }
}
