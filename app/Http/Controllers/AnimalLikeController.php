<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnimalLikeController extends Controller
{
    public function index(Request $request): View
    {
        $likedAnimals = $request->user()
            ->likedAnimals()
            ->with(['breed.species', 'animalImages.image'])
            ->orderByDesc('animals.id')
            ->paginate(12)
            ->withQueryString();

        return view('user.liked-animals.index', compact('likedAnimals'));
    }

    public function toggle(Animal $animal): RedirectResponse
    {
        $user = auth()->user();

        $alreadyLiked = $user->likedAnimals()
            ->where('animals.id', $animal->id)
            ->exists();

        if ($alreadyLiked) {
            $user->likedAnimals()->detach($animal->id);

            return back()->with('status', 'Usunięto polubienie.');
        }

        // zeby nie dodać drugiego takiego samego lika
        $user->likedAnimals()->syncWithoutDetaching([$animal->id]);

        return back()->with('status', 'Polubiono zwierzę.');
    }
}
