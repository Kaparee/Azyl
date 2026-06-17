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
    /**
     * Lista aktywnych zbiórek — dane do kafelków przygotowujemy tutaj, nie w Blade.
     */
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

        $fundraisers->getCollection()->transform(function ($fundraiser) {
            $fundraiser->setAttribute('image_url', \App\Support\FundraiserPresenter::imageUrl($fundraiser));
            $fundraiser->setAttribute('progress_percent', \App\Support\FundraiserPresenter::progressPercent($fundraiser));

            return $fundraiser;
        });

        $canCreateFundraiser = auth()->check()
            && in_array(auth()->user()->role?->name, ['Admin', 'Pracownik']);

        return view('fundraisers.index', compact('fundraisers', 'canCreateFundraiser'));
    }

    /** Tylko dostępne zwierzęta — zbiórka ma sens dla tych, które jeszcze są w schronisku. */
    public function create()
    {
        $animals = Animal::where('status', AnimalStatus::AVAILABLE)->get();

        return view('fundraisers.create', compact('animals'));
    }

    /** Nowa zbiórka startuje z zerową kwotą — wpłaty dopisuje osobny moduł darowizn. */
    public function store(StoreFundraiserRequest $request)
    {
        // Losujemy token QR aż będzie unikalny — unikamy kolizji przy skanowaniu.
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

    /** Szczegóły zbiórki — procent i etykiety przygotowujemy tutaj, żeby widok był tylko prezentacją. */
    public function show(Fundraiser $fundraiser)
    {
        $fundraiser->load(['animal.breed.species', 'animal.animalImages.image', 'donations' => function ($q) {
            $q->latest()->take(5)->with('user');
        }]);

        $fundraiser->setAttribute('progress_percent', \App\Support\FundraiserPresenter::progressPercent($fundraiser));

        if ($fundraiser->animal) {
            $fundraiser->animal->setAttribute('gender_label', \App\Support\AnimalPresenter::genderLabel($fundraiser->animal));
        }

        $canEdit = auth()->check()
            && in_array(auth()->user()->role?->name, ['Admin', 'Pracownik']);

        return view('fundraisers.show', compact('fundraiser', 'canEdit'));
    }

    public function edit(Fundraiser $fundraiser)
    {
        // Przy edycji zostawiamy też obecne zwierzę, nawet jeśli już nie jest dostępne.
        $animals = Animal::where('status', AnimalStatus::AVAILABLE)
            ->orWhere('id', $fundraiser->animal_id)
            ->get();

        $endDateFormatted = $fundraiser->end_date
            ? \App\Support\DatePresenter::formatDate($fundraiser->end_date)
            : '';

        return view('fundraisers.edit', compact('fundraiser', 'animals', 'endDateFormatted'));
    }

    /** Edycja bez zmiany zebranej kwoty — wpłaty są niezależne od formularza admina. */
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

    /** Usuwamy całą zbiórkę — darowizny zostają w bazie przez relacje, ale nie są już widoczne publicznie. */
    public function destroy(Fundraiser $fundraiser)
    {
        $fundraiser->delete();

        return redirect()->route('fundraisers.index')
            ->with('success', 'Zbiórka została usunięta pomyślnie');
    }
}
