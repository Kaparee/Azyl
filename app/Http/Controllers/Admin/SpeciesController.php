<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Species;
use Illuminate\Http\Request;

class SpeciesController extends Controller
{
    // słownik gatunków
    public function index()
    {
        $species = Species::paginate(15);

        return view('admin.species.index', [
            'species' => $species,
        ]);
    }

    public function create()
    {
        return view('admin.species.create');
    }

    public function store(Request $request)
    {
        // nazwa gatunku musi być unikalna
        $data = $request->validate([
            'name' => 'required|max:255|unique:species,name',
        ]);

        Species::create($data);

        return redirect()->route('admin.species.index')->with('status', 'Dodano gatunek.');
    }

    public function edit(Species $species)
    {
        return view('admin.species.edit', [
            'species' => $species,
        ]);
    }

    public function update(Request $request, Species $species)
    {
        // przy edycji Laravel ma zignorować aktualny rekord.
        $data = $request->validate([
            'name' => 'required|max:255|unique:species,name,'.$species->id,
        ]);

        $species->update($data);

        return redirect()->route('admin.species.index')->with('status', 'Zapisano gatunek.');
    }

    public function destroy(Species $species)
    {
        $species->delete();

        return redirect()->route('admin.species.index')->with('status', 'Usunięto gatunek.');
    }
}
