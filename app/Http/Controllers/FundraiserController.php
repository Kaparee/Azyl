<?php

namespace App\Http\Controllers;

use App\Enums\AnimalStatus;
use App\Http\Requests\StoreFundraiserRequest;
use App\Models\Animal;
use App\Models\Fundraiser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FundraiserController extends Controller
{
    public function index(Request $request)
    {
        $query = Fundraiser::with(['animal.animalImages.image'])
            ->where('status', 1);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%');
            });
        }

        $fundraisers = $query->latest()->paginate(12)->withQueryString();

        return view('fundraisers.index', compact('fundraisers'));
    }

    public function create()
    {
        $animals = Animal::where('status', AnimalStatus::AVAILABLE)->get();

        return view('fundraisers.create', compact('animals'));
    }

    public function store(StoreFundraiserRequest $request)
    {
        do {
            $qrToken = Str::random(32);
        } while (Fundraiser::where('qr_token', $qrToken)->exists());

        $fundraiser = Fundraiser::create([
            'animal_id' => $request->animal_id,
            'title' => $request->title,
            'description' => $request->description,
            'target_amount' => $request->target_amount,
            'collected_amount' => 0.00,
            'qr_token' => $qrToken,
            'status' => 1,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('fundraisers.index')
            ->with('success', 'Zbiórka została utworzona pomyślnie');
    }

    public function show(Fundraiser $fundraiser)
    {
        $fundraiser->load(['animal', 'donations' => function ($q) {
            $q->latest()->take(5)->with('user');
        }]);

        return view('fundraisers.show', compact('fundraiser'));
    }

    public function edit(Fundraiser $fundraiser)
    {
        $animals = Animal::where('status', AnimalStatus::AVAILABLE)
            ->orWhere('id', $fundraiser->animal_id)
            ->get();

        return view('fundraisers.edit', compact('fundraiser', 'animals'));
    }

    public function update(Request $request, Fundraiser $fundraiser)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'target_amount' => 'required|numeric|min:1',
            'animal_id' => 'nullable|exists:animals,id',
            'end_date' => 'nullable|date',
        ]);

        $fundraiser->update($validated);

        return redirect()->route('fundraisers.show', $fundraiser)
            ->with('success', 'Zbiórka została zaktualizowana pomyślnie');
    }

    public function destroy(Fundraiser $fundraiser)
    {
        $fundraiser->delete();

        return redirect()->route('fundraisers.index')
            ->with('success', 'Zbiórka została usunięta pomyślnie');
    }
}
