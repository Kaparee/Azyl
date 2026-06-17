<?php

namespace App\Http\Controllers\Api;

use App\Enums\AnimalStatus;
use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\Fundraiser;
use App\Models\News;
use App\Models\Species;
use OpenApi\Attributes as OA;

class StatsController extends Controller
{
    #[OA\Get(
        path: '/api/stats',
        summary: 'Pobierz podsumowanie publiczne',
        description: 'Zwraca podstawowe statystyki schroniska (liczba zwierząt, zbiórek, aktualności).',
        tags: ['Statystyki']
    )]
    #[OA\Response(
        response: 200,
        description: 'Sukces',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'animals_total', type: 'integer'),
                new OA\Property(property: 'animals_available', type: 'integer'),
                new OA\Property(property: 'active_fundraisers', type: 'integer'),
                new OA\Property(property: 'published_news', type: 'integer'),
                new OA\Property(property: 'species_count', type: 'integer'),
            ],
            type: 'object'
        )
    )]
    public function index()
    {
        return response()->json([
            'animals_total' => Animal::count(),
            'animals_available' => Animal::where('status', AnimalStatus::AVAILABLE)->count(),
            'active_fundraisers' => Fundraiser::where('status', 1)->count(),
            'published_news' => News::where('is_published', true)->count(),
            'species_count' => Species::count(),
        ]);
    }
}
