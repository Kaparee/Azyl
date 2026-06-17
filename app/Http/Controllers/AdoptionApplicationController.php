<?php

namespace App\Http\Controllers;

use App\Enums\AdoptionStatus;
use App\Enums\AnimalStatus;
use App\Http\Requests\StoreAdoptionApplicationRequest;
use App\Models\AdoptionApplication;
use App\Models\Animal;
use App\Support\AnimalPresenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdoptionApplicationController extends Controller
{
    /**
     * Panel personelu — wszystkie wnioski w jednym miejscu, żeby nie szukać ich po profilach zwierząt.
     */
    public function index(Request $request)
    {
        $query = AdoptionApplication::with(['user', 'animal.breed.species']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn ($uq) => $uq->where('name', 'like', '%'.$search.'%'))
                    ->orWhereHas('animal', fn ($aq) => $aq->where('name', 'like', '%'.$search.'%'));
            });
        }

        $applications = $query->latest()->paginate(15)->withQueryString();

        return view('admin.adoptions.index', compact('applications'));
    }

    /**
     * Składanie wniosku — zwierzę przechodzi w status oczekujący, żeby nikt inny go nie adoptował równolegle.
     */
    public function store(StoreAdoptionApplicationRequest $request)
    {
        $application = AdoptionApplication::create([
            'user_id' => $request->user()->id,
            'animal_id' => $request->animal_id,
            'status' => AdoptionStatus::PENDING,
            'message' => $request->message,
        ]);

        $application->animal->update(['status' => AnimalStatus::PENDING]);

        // Flash po redirect — użytkownik widzi potwierdzenie na stronie zwierzęcia.
        return redirect()->back()->with('status', 'Wniosek o adopcję został złożony pomyślnie.');
    }

    /**
     * Szczegóły wniosku dla admina — relacje ładujemy tutaj, widok tylko je wyświetla (MVC).
     */
    public function show(AdoptionApplication $application)
    {
        $application->load(['user', 'animal.breed.species']);

        return view('admin.adoptions.show', compact('application'));
    }

    /**
     * Akceptacja lub odrzucenie — status zwierzęcia musi się zmienić razem z wnioskiem, stąd transakcja.
     */
    public function update(Request $request, AdoptionApplication $application)
    {
        $request->validate([
            'status' => ['required', 'integer', 'in:1,2'],
        ]);

        $newStatus = AdoptionStatus::from($request->status);

        if ($application->status !== AdoptionStatus::PENDING) {
            return redirect()->back()->with('error', 'Ten wniosek został już przetworzony.');
        }

        // Transakcja — status zwierzęcia i wniosków musi się zmienić razem albo wcale.
        DB::transaction(function () use ($application, $newStatus) {
            $application->update(['status' => $newStatus]);

            if ($newStatus === AdoptionStatus::APPROVED) {
                $application->animal->update(['status' => AnimalStatus::ADOPTED]);

                // Pozostałe oczekujące wnioski anulujemy — zwierzę ma już nowego właściciela.
                AdoptionApplication::where('animal_id', $application->animal_id)
                    ->where('id', '!=', $application->id)
                    ->where('status', AdoptionStatus::PENDING)
                    ->update(['status' => AdoptionStatus::CANCELLED]);
            } else {
                $pendingCount = AdoptionApplication::where('animal_id', $application->animal_id)
                    ->where('status', AdoptionStatus::PENDING)
                    ->count();

                if ($pendingCount === 0 && $application->animal->status === AnimalStatus::PENDING) {
                    $application->animal->update(['status' => AnimalStatus::AVAILABLE]);
                }
            }
        });

        return redirect()->back()->with('success', 'Status wniosku został zaktualizowany.');
    }

    /**
     * Moje wnioski — użytkownik widzi tylko swoje; zdjęcia formatujemy tutaj, nie w Blade.
     */
    public function myApplications(Request $request)
    {
        $query = AdoptionApplication::with(['animal.breed.species', 'animal.animalImages.image'])
            ->where('user_id', $request->user()->id);

        if ($request->filled('search')) {
            $query->whereHas('animal', fn ($q) => $q->where('name', 'like', '%'.$request->search.'%'));
        }

        $applications = $query->latest()->paginate(15)->withQueryString();

        $applications->getCollection()->transform(function (AdoptionApplication $application) {
            $application->animal->setAttribute('photo_url', AnimalPresenter::photoUrl($application->animal));

            return $application;
        });

        return view('user.adoptions.index', compact('applications'));
    }

    /**
     * Sprawdzamy user_id — inaczej ktoś mógłby podejrzeć cudzy wniosek znając tylko ID w URL.
     */
    public function showMyApplication(Request $request, AdoptionApplication $application)
    {
        if ($application->user_id !== $request->user()->id) {
            abort(403, 'Nie masz dostępu do tego wniosku.');
        }

        $application->load(['animal.animalImages.image', 'animal.breed.species']);

        $photoUrl = AnimalPresenter::photoUrl($application->animal);

        return view('user.adoptions.show', compact('application', 'photoUrl'));
    }

    /**
     * Wycofanie wniosku — tylko oczekujące; po ostatnim wycofaniu zwierzę wraca do adopcji.
     */
    public function destroy(AdoptionApplication $application)
    {
        if ($application->user_id !== auth()->id()) {
            abort(403, 'Brak dostępu.');
        }

        if ($application->status !== AdoptionStatus::PENDING) {
            return back()->with('error', 'Można usunąć tylko oczekujące wnioski.');
        }

        // Po usunięciu ostatniego wniosku przywracamy zwierzę do adopcji.
        DB::transaction(function () use ($application) {
            $animalId = $application->animal_id;
            $application->delete();

            $pendingCount = AdoptionApplication::where('animal_id', $animalId)
                ->where('status', AdoptionStatus::PENDING)
                ->count();

            $animal = Animal::find($animalId);
            if ($pendingCount === 0 && $animal && $animal->status === AnimalStatus::PENDING) {
                $animal->update(['status' => AnimalStatus::AVAILABLE]);
            }
        });

        return redirect()->route('user.adoption-applications.index')
            ->with('status', 'Wniosek został usunięty.');
    }
}
