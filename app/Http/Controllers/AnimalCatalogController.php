<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\AnimalClick;
use App\Models\Breed;
use App\Models\Species;
use Illuminate\Http\Request;

class AnimalCatalogController extends Controller
{
    // katalog zwierząt z filtrami
    public function index(Request $request)
    {
        $animals = Animal::with(['breed.species', 'animalImages.image'])
            ->withCount('likedByUsers')
            ->withCount('recentClicks')
            ->orderBy('recent_clicks_count', 'desc');

        if ($request->q) {
            $animals->where(function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->q.'%')
                    ->orWhere('description', 'like', '%'.$request->q.'%');
            });
        }

        if ($request->species_id) {
            $animals->whereHas('breed', function ($query) use ($request) {
                $query->where('species_id', $request->species_id);
            });
        }

        if ($request->breed_id) {
            $animals->where('breed_id', $request->breed_id);
        }

        if ($request->status !== null && $request->status !== '') {
            $animals->where('status', $request->status);
        }

        if ($request->genders !== null && $request->genders !== '') {
            $animals->where('genders', $request->genders);
        }

        if ($request->age_from) {
            $animals->where('age_months', '>=', $request->age_from * 12);
        }

        if ($request->age_to) {
            $animals->where('age_months', '<=', $request->age_to * 12);
        }

        $animals = $animals->paginate(9)->withQueryString();

        return view('animals.index', [
            'animals' => $animals,
            'species' => Species::all(),
            'breeds' => Breed::with('species')->get(),
        ]);
    }

    public function show(Animal $animal)
    {
        $animal->load(['breed.species', 'animalImages.image', 'medicalRecords'])
            ->loadCount('likedByUsers');

        $isLiked = auth()->check()
            ? auth()->user()->likedAnimals()->where('animals.id', $animal->id)->exists()
            : false;

        return view('animals.show', [
            'animal' => $animal,
            'isLiked' => $isLiked,
        ]);
    }

    // Wejście z kodu QR. Token jest krótszy i nie pokazuje ID zwierzęcia.
    public function qr($qr_token)
    {
        $animal = Animal::where('qr_token', $qr_token)->firstOrFail();
        $animal->increment('click_count');
        AnimalClick::create(['animal_id' => $animal->id, 'clicked_at' => now()]);

        return redirect()->route('animals.show', $animal);
    }
}
