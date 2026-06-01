<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AnimalStatus;
use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\Breed;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AnimalController extends Controller
{
    // lista zwierząt w panelu admina razem z prostymi licznikami do kafelków
    public function index()
    {
        $animals = Animal::with('breed.species')->paginate(10);

        return view('admin.animals.index', [
            'animals' => $animals,
            'availableCount' => Animal::where('status', AnimalStatus::AVAILABLE)->count(),
            'pendingCount' => Animal::where('status', AnimalStatus::PENDING)->count(),
            'adoptedCount' => Animal::where('status', AnimalStatus::ADOPTED)->count(),
            'unavailableCount' => Animal::where('status', AnimalStatus::UNAVAILABLE)->count(),
        ]);
    }

    public function create()
    {
        return view('admin.animals.create', [
            'breeds' => Breed::with('species')->get(),
            'statuses' => AnimalStatus::cases(),
        ]);
    }

    public function store(Request $request)
    {
        // walidacja bo nie ma sensu robić osobnej klasy
        $data = $request->validate([
            'name' => 'required|max:255',
            'breed_id' => 'required|exists:breeds,id',
            'age_months' => 'required|integer|min:0',
            'genders' => 'required|integer|in:0,1',
            'height' => 'required|integer|min:0',
            'color' => 'required|max:255',
            'description' => 'required',
            'medical_info' => 'nullable',
            'adoption_fee' => 'required|numeric|min:0',
            'status' => 'required|integer|in:0,1,2,3',
            'arrival_date' => 'required|date',
        ]);

        // token jest potrzebny w animals więc robimy go od razu przy dodawaniu
        do {
            $token = Str::random(16);
        } while (Animal::where('qr_token', $token)->exists());

        $data['qr_token'] = $token;
        $data['click_count'] = 0;

        Animal::create($data);

        return redirect()->route('admin.animals.index')->with('status', 'Dodano zwierzę.');
    }

    public function edit(Animal $animal)
    {
        return view('admin.animals.edit', [
            'animal' => $animal,
            'breeds' => Breed::with('species')->get(),
            'statuses' => AnimalStatus::cases(),
        ]);
    }

    public function update(Request $request, Animal $animal)
    {
        // edycja ma prawie te same pola co dodawanie
        $data = $request->validate([
            'name' => 'required|max:255',
            'breed_id' => 'required|exists:breeds,id',
            'age_months' => 'required|integer|min:0',
            'genders' => 'required|integer|in:0,1',
            'height' => 'required|integer|min:0',
            'color' => 'required|max:255',
            'description' => 'required',
            'medical_info' => 'nullable',
            'adoption_fee' => 'required|numeric|min:0',
            'status' => 'required|integer|in:0,1,2,3',
            'arrival_date' => 'required|date',
        ]);

        $animal->update($data);

        return redirect()->route('admin.animals.index')->with('status', 'Zapisano zwierzę.');
    }

    public function destroy(Animal $animal)
    {
        $animal->delete();

        return redirect()->route('admin.animals.index')->with('status', 'Usunięto zwierzę.');
    }
}
