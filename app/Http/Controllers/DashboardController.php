<?php

namespace App\Http\Controllers;

use App\Enums\AdoptionStatus;
use App\Models\AdoptionApplication;
use App\Models\Animal;
use App\Models\Donation;
use App\Models\Species;
use App\Models\User;
use App\Models\VolunteerTask;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role?->name;

        if ($role === 'Admin') {
            return $this->adminDashboard();
        }

        if ($role === 'Weterynarz') {
            return $this->vetDashboard();
        }

        if ($role === 'Pracownik') {
            return $this->workerDashboard();
        }

        if ($role === 'Wolontariusz') {
            return $this->volunteerDashboard();
        }

        return $this->userDashboard();
    }

    private function calculatePercentageChange($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }

        return round((($current - $previous) / $previous) * 100);
    }

    private function adminDashboard()
    {
        $currentMonth = Carbon::now()->month;
        $previousMonth = Carbon::now()->subMonth()->month;

        $animalsCount = Animal::count();
        $animalsThisMonth = Animal::whereMonth('created_at', $currentMonth)->count();
        $animalsLastMonth = Animal::whereMonth('created_at', $previousMonth)->count();
        $animalsDiff = $this->calculatePercentageChange($animalsThisMonth, $animalsLastMonth);

        $pendingApplicationsCount = AdoptionApplication::where('status', AdoptionStatus::PENDING->value)->count();
        $applicationsThisMonth = AdoptionApplication::whereMonth('created_at', $currentMonth)->count();
        $applicationsLastMonth = AdoptionApplication::whereMonth('created_at', $previousMonth)->count();
        $applicationsDiff = $this->calculatePercentageChange($applicationsThisMonth, $applicationsLastMonth);

        $adoptionsThisMonthCount = AdoptionApplication::where('status', AdoptionStatus::APPROVED->value)->whereMonth('updated_at', $currentMonth)->count();
        $adoptionsLastMonthCount = AdoptionApplication::where('status', AdoptionStatus::APPROVED->value)->whereMonth('updated_at', $previousMonth)->count();
        $adoptionsDiff = $this->calculatePercentageChange($adoptionsThisMonthCount, $adoptionsLastMonthCount);

        $donationsSum = Donation::whereMonth('created_at', $currentMonth)->sum('amount');
        $donationsLastMonthSum = Donation::whereMonth('created_at', $previousMonth)->sum('amount');
        $donationsDiff = $this->calculatePercentageChange($donationsSum, $donationsLastMonthSum);

        $speciesDistribution = Species::withCount(['breeds as animals_count' => function ($query) {
            $query->join('animals', 'animals.breed_id', '=', 'breeds.id');
        }])->get();

        $speciesLabels = $speciesDistribution->pluck('name')->toArray();
        $speciesData = $speciesDistribution->pluck('animals_count')->toArray();

        $urgentTasks = VolunteerTask::where('status', 1)->orderBy('time')->take(4)->get();

        $last12Months = collect(range(11, 0))->map(function ($i) {
            return Carbon::now()->subMonths($i);
        });

        $months = $last12Months->map(function ($date) {
            return $date->translatedFormat('M y');
        })->toArray();

        $adoptionsData = AdoptionApplication::selectRaw('YEAR(updated_at) as year, MONTH(updated_at) as month, count(*) as count')
            ->where('status', AdoptionStatus::APPROVED->value)
            ->where('updated_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('year', 'month')
            ->get()
            ->keyBy(function ($item) {
                return $item->year.'-'.str_pad($item->month, 2, '0', STR_PAD_LEFT);
            });

        $monthlyAdoptions = $last12Months->map(function ($date) use ($adoptionsData) {
            $key = $date->format('Y-m');

            return $adoptionsData->has($key) ? $adoptionsData[$key]->count : 0;
        })->toArray();

        return view('dashboard.admin', compact(
            'animalsCount',
            'pendingApplicationsCount',
            'adoptionsThisMonthCount',
            'donationsSum',
            'animalsDiff',
            'applicationsDiff',
            'adoptionsDiff',
            'donationsDiff',
            'speciesLabels',
            'speciesData',
            'urgentTasks',
            'months',
            'monthlyAdoptions'
        ));
    }

    private function vetDashboard()
    {
        $patientsCount = Animal::count();
        $medicalTasks = VolunteerTask::where('title', 'like', '%Leki%')
            ->orWhere('title', 'like', '%Kontrola%')
            ->where('status', 1)
            ->get();

        return view('dashboard.vet', compact('patientsCount', 'medicalTasks'));
    }

    private function workerDashboard()
    {
        $animalsCount = Animal::count();
        $pendingApplicationsCount = AdoptionApplication::where('status', AdoptionStatus::PENDING->value)->count();

        return view('dashboard.worker', compact('animalsCount', 'pendingApplicationsCount'));
    }

    private function volunteerDashboard()
    {
        $tasks = VolunteerTask::where('assigned_to', Auth::id())->get();
        $completedToday = $tasks->where('status', 3)->count();
        $pending = $tasks->where('status', 1)->count();

        return view('dashboard.volunteer', compact('tasks', 'completedToday', 'pending'));
    }

    private function userDashboard()
    {
        /** @var User $user */
        $user = Auth::user();
        
        // Contextual Search query from request
        $query = request('q');

        // 1. Applications (filtered if searching on dashboard or my applications)
        $applicationsQuery = $user->adoptionApplications()->with(['animal.images', 'animal.breed.species']);
        if ($query && request('tab') === 'applications') {
            $applicationsQuery->whereHas('animal', function($q) use ($query) {
                $q->where('name', 'like', '%'.$query.'%')
                  ->orWhere('description', 'like', '%'.$query.'%');
            });
        }
        $applications = $applicationsQuery->latest()->get();

        // 2. Donations
        $donationsQuery = $user->donations()->with('fundraiser.animal');
        if ($query && request('tab') === 'donations') {
            $donationsQuery->whereHas('fundraiser', function($q) use ($query) {
                $q->where('title', 'like', '%'.$query.'%')
                  ->orWhere('description', 'like', '%'.$query.'%');
            });
        }
        $donations = $donationsQuery->latest()->get();

        // 3. Liked Animals
        $likedAnimalsQuery = $user->likedAnimals()->with(['breed.species', 'images']);
        if ($query && request('tab') === 'likes') {
            $likedAnimalsQuery->where(function($q) use ($query) {
                $q->where('name', 'like', '%'.$query.'%')
                  ->orWhere('description', 'like', '%'.$query.'%');
            });
        }
        $likedAnimals = $likedAnimalsQuery->latest()->get();

        // 4. Animal Suggestions (proponowane zwierzaki o statusie AVAILABLE = 0, z wykluczeniem już polubionych)
        $likedAnimalIds = $likedAnimals->pluck('id')->toArray();
        
        // Bazujemy na preferowanym gatunku z polubionych zwierzaków
        $preferredBreedIds = $likedAnimals->pluck('breed_id')->unique()->toArray();
        
        $suggestionsQuery = Animal::with(['breed.species', 'images'])
            ->where('status', 0) // AVAILABLE
            ->whereNotIn('id', $likedAnimalIds);

        if (!empty($preferredBreedIds)) {
            $suggestionsQuery->orderByRaw('CASE WHEN breed_id IN (' . implode(',', $preferredBreedIds) . ') THEN 0 ELSE 1 END');
        }

        $suggestions = $suggestionsQuery->inRandomOrder()->take(3)->get();

        return view('dashboard.user', compact('user', 'applications', 'donations', 'likedAnimals', 'suggestions'));
    }
}
