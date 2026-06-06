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
     * Display a listing of applications (Admin/Volunteer).
     */
    public function index()
    {
        $applications = AdoptionApplication::with(['user', 'animal'])
            ->latest()
            ->paginate(15);

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

        return redirect()->back()->with('success', 'Wniosek o adopcję został złożony pomyślnie.');
    }

    /**
     * Display the specified application.
     */
    public function show(AdoptionApplication $application)
    {
        $application->load(['user', 'animal']);
        return view('admin.adoptions.show', compact('application'));
    }

    /**
     * Update the status of the application (Admin/Volunteer).
     */
    public function update(Request $request, AdoptionApplication $application)
    {
        $request->validate([
            'status' => ['required', 'integer', 'in:1,2'], // APPROVED or REJECTED
        ]);

        $newStatus = AdoptionStatus::from($request->status);

        if ($application->status !== AdoptionStatus::PENDING) {
            return redirect()->back()->with('error', 'Ten wniosek został już przetworzony.');
        }

        DB::transaction(function () use ($application, $newStatus) {
            $application->update(['status' => $newStatus]);

            if ($newStatus === AdoptionStatus::APPROVED) {
                // Mark animal as ADOPTED
                $application->animal->update(['status' => AnimalStatus::ADOPTED]);

                // Optionally: Cancel other pending applications for this animal
                AdoptionApplication::where('animal_id', $application->animal_id)
                    ->where('id', '!=', $application->id)
                    ->where('status', AdoptionStatus::PENDING)
                    ->update(['status' => AdoptionStatus::CANCELLED]);
            }
        });

        return redirect()->back()->with('success', 'Status wniosku został zaktualizowany.');
    }
}
