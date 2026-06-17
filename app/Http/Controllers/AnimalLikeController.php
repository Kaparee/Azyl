<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Support\AnimalPresenter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnimalLikeController extends Controller
{
    /**
     * Ulubione zwierzęta użytkownika — zdjęcia formatujemy tutaj, żeby widok był prosty.
     */
    public function index(Request $request): View
    {
        $likedAnimals = $request->user()
            ->likedAnimals()
            ->with(['breed.species', 'animalImages.image'])
            ->orderByDesc('animals.id')
            ->paginate(12)
            ->withQueryString();

        $likedAnimals->getCollection()->transform(function (Animal $animal) {
            $animal->setAttribute('photo_url', AnimalPresenter::photoUrl($animal));

            return $animal;
        });

        return view('user.liked-animals.index', compact('likedAnimals'));
    }

    public function toggle(Animal $animal): RedirectResponse
    {
        $user = auth()->user();

        // Sprawdzamy pivot — ten sam endpoint obsługuje dodanie i usunięcie polubienia.
        $alreadyLiked = $user->likedAnimals()
            ->where('animals.id', $animal->id)
            ->exists();

        if ($alreadyLiked) {
            $user->likedAnimals()->detach($animal->id);

            return back()->with('status', 'Usunięto polubienie.');
        }

        // syncWithoutDetaching — dodaje polubienie bez duplikatu w tabeli pivot.
        $user->likedAnimals()->syncWithoutDetaching([$animal->id]);

        return back()->with('status', 'Polubiono zwierzę.');
    }
}
