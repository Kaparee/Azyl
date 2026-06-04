<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Animal;
use App\Models\AdoptionApplication;
use App\Models\Donation;
use App\Models\VolunteerTask;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1 - Administrator
        if ($user->role_id == 1) {
            return $this->adminDashboard();
        }
        
        // 2 - Weterynarz
        if ($user->role_id == 2) {
            return $this->vetDashboard();
        }

        // 3 - Pracownik
        if ($user->role_id == 3) {
            return $this->workerDashboard();
        }

        // 4 - Wolontariusz
        if ($user->role_id == 4) {
            return $this->volunteerDashboard();
        }

        // 5 - Adoptujący
        return $this->userDashboard();
    }

    private function adminDashboard()
    {
        $animalsCount = Animal::count();
        $pendingApplicationsCount = AdoptionApplication::where('status', 'pending')->count();
        $adoptionsThisMonthCount = AdoptionApplication::where('status', 'approved')->whereMonth('updated_at', date('m'))->count();
        $donationsSum = Donation::whereMonth('created_at', date('m'))->sum('amount');
        
        // Dane do wykresów (gatunki po powiązanej rasie - dynamicznie wszystkie!)
        $speciesDistribution = \App\Models\Species::withCount(['breeds as animals_count' => function ($query) {
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
            ->where('status', 'approved')
            ->where('updated_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('year', 'month')
            ->get()
            ->keyBy(function ($item) {
                return $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT);
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
            'speciesLabels',
            'speciesData',
            'urgentTasks',
            'months',
            'monthlyAdoptions'
        ));
    }

    private function vetDashboard()
    {
        $patientsCount = Animal::count(); // lub tylko chore
        $medicalTasks = VolunteerTask::where('title', 'like', '%Leki%')
                                     ->orWhere('title', 'like', '%Kontrola%')
                                     ->where('status', 1)
                                     ->get();

        return view('dashboard.vet', compact('patientsCount', 'medicalTasks'));
    }

    private function workerDashboard()
    {
        $animalsCount = Animal::count();
        $pendingApplicationsCount = AdoptionApplication::where('status', 'pending')->count();
        
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
        $applications = AdoptionApplication::where('user_id', Auth::id())->get();
        return view('dashboard.user', compact('applications'));
    }
}
