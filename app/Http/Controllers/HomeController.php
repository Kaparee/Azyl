<?php

namespace App\Http\Controllers;

use App\Enums\AnimalStatus;
use App\Models\Animal;
use App\Models\Fundraiser;
use App\Models\News;
use App\Support\AnimalPresenter;
use App\Support\FundraiserPresenter;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Strona główna — dane pobieramy tutaj, widok tylko je wyświetla (MVC).
     */
    public function index(): View
    {
        // Najpopularniejsze zwierzęta dostępne do adopcji (ostatnie 30 dni kliknięć).
        $recentAnimals = Animal::with(['breed.species', 'animalImages.image'])
            ->where('status', AnimalStatus::AVAILABLE)
            ->withCount('recentClicks')
            ->orderByDesc('recent_clicks_count')
            ->take(5)
            ->get()
            ->map(function (Animal $animal) {
                $animal->setAttribute('photo_url', AnimalPresenter::photoUrl($animal));

                return $animal;
            });

        // Aktywne zbiórki z danymi do wyświetlenia (zdjęcie, procent postępu).
        $recentFundraisers = FundraiserPresenter::withDisplayData(
            Fundraiser::with(['animal.animalImages.image'])
                ->where('status', 1)
                ->latest()
                ->take(2)
                ->get()
        );

        $recentNews = News::where('is_published', true)
            ->latest('published_at')
            ->take(1)
            ->get();

        // Jeden artykuł wystarczy na baner — reszta jest na osobnej podstronie aktualności.
        return view('welcome', compact('recentAnimals', 'recentFundraisers', 'recentNews'));
    }
}
