<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Animal::with(['breed', 'medicalRecords' => function($q) {
            $q->orderByDesc('treatment_date');
        }]);

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
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

        \App\Models\MedicalRecord::create($validated);

        return back()->with('success', 'Dodano nowy wpis medyczny.');
    }
}
