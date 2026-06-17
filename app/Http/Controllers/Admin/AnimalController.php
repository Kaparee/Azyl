<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AnimalStatus;
use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\AnimalImage;
use App\Models\Breed;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AnimalController extends Controller
{
    // lista zwierząt w panelu admina razem z prostymi licznikami do kafelków
    public function index(Request $request)
    {
        $query = Animal::with(['breed.species', 'animalImages.image'])->latest();

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhereHas('breed', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%')
                        ->orWhereHas('species', function($q2) use ($request) {
                            $q2->where('name', 'like', '%' . $request->search . '%');
                        });
                  });
        }

        $animals = $query->paginate(10)->withQueryString();

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
        $employees = \App\Models\User::whereHas('role', fn($q) => $q->where('name', 'Pracownik'))->orderBy('name')->get();
        $volunteers = \App\Models\User::whereHas('role', fn($q) => $q->where('name', 'Wolontariusz'))->orderBy('name')->get();

        return view('admin.animals.create', [
            'breeds' => Breed::with('species')->get(),
            'statuses' => AnimalStatus::cases(),
            'employees' => $employees,
            'volunteers' => $volunteers,
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
            'images.*' => 'nullable|image|max:5120',
            'sort_order' => 'nullable|array',
            'sort_order.*' => 'nullable|integer|min:0',
            
            // Nowe pola
            'traits' => 'nullable|array',
            'traits.*' => 'string',
            'housing_conditions' => 'nullable|string|max:255',
            'experience_required' => 'nullable|string|max:255',
            'daily_time_required' => 'nullable|string|max:255',
            'caregiver_id' => 'nullable|exists:users,id',
            'contact_phone' => 'nullable|string|max:255',
            'visiting_hours' => 'nullable|string|max:255',
        ]);

        $data['is_child_friendly'] = $request->has('is_child_friendly');
        $data['accepts_cats'] = $request->has('accepts_cats');
        $data['accepts_dogs'] = $request->has('accepts_dogs');
        $data['requires_responsible_caregiver'] = $request->has('requires_responsible_caregiver');

        unset($data['images'], $data['sort_order']);

        // token jest potrzebny w animals więc robimy go od razu przy dodawaniu
        do {
            $token = Str::random(10);
        } while (Animal::where('qr_token', $token)->exists());

        $data['qr_token'] = $token;

        $animal = Animal::create($data);

        // zdjęcia są zapisywane po kolei
        if ($request->hasFile('images')) {
            $sortOrders = $request->input('sort_order', []);
            $nr = 1;

            foreach ($request->file('images') as $index => $file) {
                $path = $file->store('animals', 'public');

                $image = Image::create([
                    'animal_id' => $animal->id,
                    'file_name' => $path,
                    'original_file_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getClientMimeType(),
                ]);

                AnimalImage::create([
                    'animal_id' => $animal->id,
                    'image_id' => $image->id,
                    'sort_order' => $sortOrders[$index] ?? $nr,
                ]);

                $nr++;
            }
        }

        return redirect()->route('admin.animals.index')->with('status', 'Dodano zwierzę.');
    }

    public function edit(Animal $animal)
    {
        $animal->load('animalImages.image');
        $employees = \App\Models\User::whereHas('role', fn($q) => $q->where('name', 'Pracownik'))->orderBy('name')->get();
        $volunteers = \App\Models\User::whereHas('role', fn($q) => $q->where('name', 'Wolontariusz'))->orderBy('name')->get();

        return view('admin.animals.edit', [
            'animal' => $animal,
            'breeds' => Breed::with('species')->get(),
            'statuses' => AnimalStatus::cases(),
            'employees' => $employees,
            'volunteers' => $volunteers,
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
            'images.*' => 'nullable|image|max:5120',
            'sort_order' => 'nullable|array',
            'sort_order.*' => 'nullable|integer|min:0',

            // Nowe pola
            'traits' => 'nullable|array',
            'traits.*' => 'string',
            'housing_conditions' => 'nullable|string|max:255',
            'experience_required' => 'nullable|string|max:255',
            'daily_time_required' => 'nullable|string|max:255',
            'caregiver_id' => 'nullable|exists:users,id',
            'contact_phone' => 'nullable|string|max:255',
            'visiting_hours' => 'nullable|string|max:255',
        ]);

        $data['is_child_friendly'] = $request->has('is_child_friendly');
        $data['accepts_cats'] = $request->has('accepts_cats');
        $data['accepts_dogs'] = $request->has('accepts_dogs');
        $data['requires_responsible_caregiver'] = $request->has('requires_responsible_caregiver');

        unset($data['images'], $data['sort_order']);

        if ($data['status'] != $animal->status->value) {
            $pendingApplicationsCount = $animal->adoptionApplications()->where('status', \App\Enums\AdoptionStatus::PENDING)->count();
            if ($pendingApplicationsCount > 0 && in_array($data['status'], [\App\Enums\AnimalStatus::ADOPTED->value, \App\Enums\AnimalStatus::UNAVAILABLE->value])) {
                return redirect()->back()->withInput()->withErrors(['status' => 'Zwierzę ma jeszcze nierozpatrzone wnioski adopcyjne! Zmień ich status na odrzucony, by kontynuować.']);
            }
        }

        $animal->update($data);

        // zmiana kolejności dodanych zdjęc
        if ($request->sort_order) {
            foreach ($request->sort_order as $animalImageId => $order) {
                $ai = AnimalImage::where('animal_id', $animal->id)->where('id', $animalImageId)->first();
                if ($ai) {
                    $ai->update(['sort_order' => $order]);
                }
            }
        } // nowe zdjęcie dopisujemy na koniec
        if ($request->hasFile('images')) {
            $nr = AnimalImage::where('animal_id', $animal->id)->max('sort_order');
            $nr = $nr ? $nr + 1 : 1;

            foreach ($request->file('images') as $file) {
                $path = $file->store('animals', 'public');

                $image = Image::create([
                    'animal_id' => $animal->id,
                    'file_name' => $path,
                    'original_file_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getClientMimeType(),
                ]);

                AnimalImage::create([
                    'animal_id' => $animal->id,
                    'image_id' => $image->id,
                    'sort_order' => $nr,
                ]);

                $nr++;
            }
        }

        return redirect()->route('admin.animals.index')->with('status', 'Zapisano zwierzę.');
    }

    public function destroy(Animal $animal)
    {
        $animal->delete();

        return redirect()->route('admin.animals.index')->with('status', 'Usunięto zwierzę.');
    }
}
