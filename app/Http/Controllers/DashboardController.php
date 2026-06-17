<?php

namespace App\Http\Controllers;

use App\Enums\AdoptionStatus;
use App\Models\AdoptionApplication;
use App\Models\Animal;
use App\Models\Donation;
use App\Models\Species;
use App\Models\User;
use App\Models\VolunteerTask;
use App\Support\AnimalPresenter;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Jeden URL panelu — rola decyduje, który widok i zestaw statystyk pokazujemy użytkownikowi.
     */
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

    // Procent zmiany m/m — przy zerowym poprzednim miesiącu unikamy dzielenia przez zero.
    private function calculatePercentageChange($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }

        return round((($current - $previous) / $previous) * 100);
    }

    // Statystyki i wykresy liczymy tutaj — widok admina nie powinien odpytywać bazy samodzielnie.
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
            'months',
            'monthlyAdoptions'
        ));
    }

    /** Weterynarz potrzebuje tylko liczby pacjentów — reszta jest w module kart medycznych. */
    private function vetDashboard()
    {
        $patientsCount = Animal::count();

        return view('dashboard.vet', compact('patientsCount'));
    }

    /** Pracownik widzi skrót adopcji — szczegóły obsługuje osobna lista wniosków. */
    private function workerDashboard()
    {
        $animalsCount = Animal::count();
        $pendingApplicationsCount = AdoptionApplication::where('status', AdoptionStatus::PENDING->value)->count();

        return view('dashboard.worker', compact('animalsCount', 'pendingApplicationsCount'));
    }

    /**
     * Panel wolontariusza — statystyki liczymy z jego zadań, żeby widok tylko je pokazał.
     */
    private function volunteerDashboard()
    {
        $tasks = VolunteerTask::where('assigned_to', Auth::id())->get();
        // Postęp dzienny: ukończone vs oczekujące (status 3 vs 1).
        $completedToday = $tasks->where('status', 3)->count();
        $pending = $tasks->where('status', 1)->count();
        $totalToday = $completedToday + $pending;
        $progressPercent = $totalToday > 0 ? (int) round(($completedToday / $totalToday) * 100) : 0;
        $completedAll = $tasks->where('status', 3)->count();

        return view('dashboard.volunteer', compact(
            'tasks',
            'completedToday',
            'pending',
            'totalToday',
            'progressPercent',
            'completedAll'
        ));
    }

    /** Panel zwykłego użytkownika — ostatnie wnioski i darowizny, żeby nie szukać ich w menu. */
    private function userDashboard()
    {
        /** @var User $user */
        $user = Auth::user();

        $applications = $user->adoptionApplications()
            ->with(['animal.breed.species', 'animal.animalImages.image'])
            ->latest()
            ->take(5)
            ->get();

        $applications->each(function ($application) {
            $application->animal->setAttribute('photo_url', AnimalPresenter::photoUrl($application->animal));
        });

        $donations = $user->donations()->with('fundraiser.animal')->latest()->get();

        return view('dashboard.user', compact('user', 'applications', 'donations'));
    }
}
