<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Breed;
use App\Models\Species;
use Illuminate\Http\Request;

class BreedController extends Controller
{
    // Prosty CRUD ras. Rasa zawsze jest przypisana do jakiegoś gatunku.
    public function index()
    {
        $breeds = Breed::with('species')->paginate(15);

        return view('admin.breeds.index', [
            'breeds' => $breeds,
        ]);
    }

    public function create()
    {
        return view('admin.breeds.create', [
            'species' => Species::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'species_id' => 'required|exists:species,id',
        ]);

        // W bazie jest unikalna para nazwa + gatunek, więc sprawdzamy to przed zapisem.
        $exists = Breed::where('name', $data['name'])
            ->where('species_id', $data['species_id'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['name' => 'Taka rasa już istnieje dla tego gatunku.'])->withInput();
        }

        Breed::create($data);

        return redirect()->route('admin.breeds.index')->with('status', 'Dodano rasę.');
    }

    public function edit(Breed $breed)
    {
        return view('admin.breeds.edit', [
            'breed' => $breed,
            'species' => Species::all(),
        ]);
    }

    public function update(Request $request, Breed $breed)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'species_id' => 'required|exists:species,id',
        ]);

        // Przy edycji pomijamy aktualnie edytowaną rasę.
        $exists = Breed::where('name', $data['name'])
            ->where('species_id', $data['species_id'])
            ->where('id', '!=', $breed->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['name' => 'Taka rasa już istnieje dla tego gatunku.'])->withInput();
        }

        $breed->update($data);

        return redirect()->route('admin.breeds.index')->with('status', 'Zapisano rasę.');
    }

    public function destroy(Breed $breed)
    {
        $breed->delete();

        return redirect()->route('admin.breeds.index')->with('status', 'Usunięto rasę.');
    }
}
