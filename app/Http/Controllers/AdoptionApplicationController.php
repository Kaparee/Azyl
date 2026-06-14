<?php

namespace App\Http\Controllers;

use App\Enums\AdoptionStatus;
use App\Enums\AnimalStatus;
use App\Http\Requests\StoreAdoptionApplicationRequest;
use App\Models\AdoptionApplication;
use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdoptionApplicationController extends Controller
{
    /**
     * Display a listing of applications (Admin/Pracownik).
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
     * Store a newly created application in storage.
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

        return redirect()->back()->with('success', 'Wniosek o adopcję został złożony pomyślnie.');
    }

    /**
     * Display the specified application.
     */
    public function show(AdoptionApplication $application)
    {
        $application->load(['user', 'animal.breed.species']);

        return view('admin.adoptions.show', compact('application'));
    }

    /**
     * Update the status of the application (Admin/Pracownik).
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

        DB::transaction(function () use ($application, $newStatus) {
            $application->update(['status' => $newStatus]);

            if ($newStatus === AdoptionStatus::APPROVED) {
                $application->animal->update(['status' => AnimalStatus::ADOPTED]);

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
     * Display a listing of applications for the authenticated user.
     */
    public function myApplications(Request $request)
    {
        $query = AdoptionApplication::with(['animal.breed.species', 'animal.animalImages.image'])
            ->where('user_id', $request->user()->id);

        if ($request->filled('search')) {
            $query->whereHas('animal', fn ($q) => $q->where('name', 'like', '%'.$request->search.'%'));
        }

        $applications = $query->latest()->paginate(15)->withQueryString();

        return view('user.adoptions.index', compact('applications'));
    }

    /**
     * Display the specified application for the authenticated user.
     */
    public function showMyApplication(Request $request, AdoptionApplication $application)
    {
        if ($application->user_id !== $request->user()->id) {
            abort(403, 'Nie masz dostępu do tego wniosku.');
        }

        $application->load(['animal.animalImages.image', 'animal.breed.species']);

        return view('user.adoptions.show', compact('application'));
    }

    /**
     * Remove the specified pending application for the authenticated user.
     */
    public function destroy(AdoptionApplication $application)
    {
        if ($application->user_id !== auth()->id()) {
            abort(403, 'Brak dostępu.');
        }

        if ($application->status !== AdoptionStatus::PENDING) {
            return back()->with('error', 'Można usunąć tylko oczekujące wnioski.');
        }

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
