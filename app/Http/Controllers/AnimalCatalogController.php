<?php

namespace App\Http\Controllers;

use App\Enums\AdoptionStatus;
use App\Enums\AnimalStatus;
use App\Models\AdoptionApplication;
use App\Models\Animal;
use App\Models\AnimalClick;
use App\Models\Breed;
use App\Models\Species;
use App\Support\AnimalPresenter;
use App\Support\DatePresenter;
use App\Support\FundraiserPresenter;
use Illuminate\Http\Request;

class AnimalCatalogController extends Controller
{
    /**
     * Katalog zwierząt z filtrami — domyślnie tylko dostępne do adopcji.
     */
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

        // Brak statusu w URL → tylko dostępne; status=all → bez filtra.
        if ($request->status === 'all') {
            // bez filtra statusu
        } elseif ($request->filled('status')) {
            $animals->where('status', $request->status);
        } else {
            $animals->where('status', AnimalStatus::AVAILABLE);
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

        // Prezentujemy dane w kontrolerze — widok nie liczy URL ani badge.
        $animals->getCollection()->transform(function (Animal $animal) {
            $badge = AnimalPresenter::statusBadge($animal);
            $animal->setAttribute('photo_url', AnimalPresenter::photoUrl($animal));
            $animal->setAttribute('status_label', $badge['label']);
            $animal->setAttribute('status_class', $badge['class']);
            $animal->setAttribute('gender_label', AnimalPresenter::genderLabel($animal));

            return $animal;
        });

        return view('animals.index', [
            'animals' => $animals,
            'species' => Species::all(),
            'breeds' => Breed::with('species')->get(),
            'statusFilter' => $request->input('status'),
        ]);
    }

    /**
     * Profil zwierzęcia — wszystkie dane do widoku przygotowane tutaj (MVC).
     */
    public function show(Animal $animal)
    {
        $animal->load(['breed.species', 'animalImages.image', 'medicalRecords'])
            ->loadCount(['likedByUsers', 'recentClicks']);

        $isLiked = auth()->check()
            ? auth()->user()->likedAnimals()->where('animals.id', $animal->id)->exists()
            : false;

        $activeFundraiser = $animal->fundraisers()->where('status', 1)->first();
        if ($activeFundraiser) {
            $activeFundraiser->setAttribute('progress_percent', FundraiserPresenter::progressPercent($activeFundraiser));
        }

        $badge = AnimalPresenter::statusBadge($animal);

        // Sprawdzamy, czy użytkownik może złożyć wniosek (musi być zalogowany i zwierzę dostępne).
        $existingApplication = null;
        $canApply = false;

        if (auth()->check()) {
            $existingApplication = AdoptionApplication::where('user_id', auth()->id())
                ->where('animal_id', $animal->id)
                ->whereIn('status', [AdoptionStatus::PENDING, AdoptionStatus::APPROVED])
                ->first();

            $canApply = $animal->status === AnimalStatus::AVAILABLE && ! $existingApplication;
        }

        // Jeden string adoptionUi — widok nie musi znać reguł biznesowych adopcji.
        if ($animal->status === AnimalStatus::ADOPTED) {
            $adoptionUi = 'adopted';
        } elseif ($animal->status === AnimalStatus::UNAVAILABLE) {
            $adoptionUi = 'unavailable';
        } elseif (! auth()->check()) {
            $adoptionUi = 'guest';
        } elseif ($canApply) {
            $adoptionUi = 'form';
        } elseif ($existingApplication?->status === AdoptionStatus::PENDING) {
            $adoptionUi = 'pending';
        } elseif ($existingApplication?->status === AdoptionStatus::APPROVED) {
            $adoptionUi = 'approved';
        } else {
            $adoptionUi = null;
        }

        // Historia leczenia — daty sformatowane w kontrolerze, nie w Blade.
        $medicalHistory = $animal->medicalRecords
            ->sortBy('treatment_date')
            ->take(3)
            ->map(fn ($record) => [
                'treatment_type' => $record->treatment_type,
                'description' => $record->description,
                'date_formatted' => DatePresenter::formatDate($record->treatment_date),
            ])
            ->values();

        return view('animals.show', [
            'animal' => $animal,
            'isLiked' => $isLiked,
            'activeFundraiser' => $activeFundraiser,
            'photoUrls' => AnimalPresenter::photoUrls($animal),
            'placeholderUrl' => AnimalPresenter::placeholderUrl($animal),
            'qrLink' => route('animals.qr', $animal->qr_token),
            'statusLabel' => $badge['label'],
            'statusClass' => $badge['class'],
            'genderLabel' => AnimalPresenter::genderLabel($animal),
            'recentClicksCount' => $animal->recent_clicks_count,
            'canApply' => $canApply,
            'existingApplication' => $existingApplication,
            'adoptionUi' => $adoptionUi,
            'medicalHistory' => $medicalHistory,
            'isAuthenticated' => auth()->check(),
        ]);
    }

    // Wejście z kodu QR. Token jest krótszy i nie pokazuje ID zwierzęcia.
    public function qr($qr_token)
    {
        $animal = Animal::where('qr_token', $qr_token)->firstOrFail();
        AnimalClick::create(['animal_id' => $animal->id, 'clicked_at' => now()]);

        return redirect()->route('animals.show', $animal);
    }

    /**
     * Katalog w panelu wolontariusza — tylko podgląd, bez filtrów adopcyjnych ze strony publicznej.
     */
    public function panelIndex(Request $request)
    {
        $query = Animal::with(['breed.species', 'animalImages.image']);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                    ->orWhereHas('breed', function ($qb) use ($request) {
                        $qb->where('name', 'like', '%'.$request->search.'%')
                            ->orWhereHas('species', function ($qs) use ($request) {
                                $qs->where('name', 'like', '%'.$request->search.'%');
                            });
                    });
            });
        }

        $animals = $query->paginate(10)->withQueryString();

        $animals->getCollection()->transform(function (Animal $animal) {
            $animal->setAttribute('photo_url', AnimalPresenter::photoUrl($animal));

            return $animal;
        });

        return view('volunteer.animals.index', compact('animals'));
    }
}
