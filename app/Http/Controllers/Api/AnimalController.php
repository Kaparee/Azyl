<?php

namespace App\Http\Controllers\Api;

use App\Enums\AnimalStatus;
use App\Http\Controllers\Controller;
use App\Models\Animal;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class AnimalController extends Controller
{
    #[OA\Get(
        path: '/api/animals',
        summary: 'Pobierz listę zwierząt dostępnych do adopcji',
        description: 'Zwraca paginowaną listę zwierząt ze statusem AVAILABLE wraz z rasą i gatunkiem.',
        tags: ['Zwierzęta']
    )]
    #[OA\Response(
        response: 200,
        description: 'Sukces',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'current_page', type: 'integer'),
                new OA\Property(
                    property: 'data',
                    type: 'array',
                    items: new OA\Items(
                        properties: [
                            new OA\Property(property: 'id', type: 'integer'),
                            new OA\Property(property: 'name', type: 'string'),
                            new OA\Property(property: 'description', type: 'string'),
                            new OA\Property(property: 'age_months', type: 'integer'),
                            new OA\Property(property: 'status', type: 'integer'),
                            new OA\Property(property: 'breed', type: 'object'),
                        ],
                        type: 'object'
                    )
                ),
            ],
            type: 'object'
        )
    )]
    public function index(Request $request)
    {
        $animals = Animal::with(['breed.species'])
            ->where('status', AnimalStatus::AVAILABLE)
            ->paginate(15);

        return response()->json($animals);
    }

    #[OA\Get(
        path: '/api/animals/{id}',
        summary: 'Pobierz szczegóły zwierzęcia',
        description: 'Zwraca pojedyncze zwierzę z rasą, gatunkiem i podstawowymi danymi adopcyjnymi.',
        tags: ['Zwierzęta']
    )]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Response(
        response: 200,
        description: 'Sukces',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'id', type: 'integer'),
                new OA\Property(property: 'name', type: 'string'),
                new OA\Property(property: 'description', type: 'string'),
                new OA\Property(property: 'age_months', type: 'integer'),
                new OA\Property(property: 'status', type: 'integer'),
                new OA\Property(property: 'breed', type: 'object'),
            ],
            type: 'object'
        )
    )]
    #[OA\Response(response: 404, description: 'Nie znaleziono')]
    public function show(Animal $animal)
    {
        $animal->load(['breed.species']);

        return response()->json($animal);
    }

    #[OA\Get(
        path: '/api/animals/{id}/medical-records',
        summary: 'Pobierz kartotekę medyczną zwierzęcia',
        description: 'Zwraca listę wpisów medycznych przypisanych do zwierzęcia.',
        tags: ['Zwierzęta']
    )]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Response(
        response: 200,
        description: 'Sukces',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(
                properties: [
                    new OA\Property(property: 'id', type: 'integer'),
                    new OA\Property(property: 'treatment_type', type: 'string'),
                    new OA\Property(property: 'description', type: 'string'),
                    new OA\Property(property: 'cost', type: 'number', format: 'float'),
                    new OA\Property(property: 'treatment_date', type: 'string', format: 'date-time'),
                ],
                type: 'object'
            )
        )
    )]
    #[OA\Response(response: 404, description: 'Nie znaleziono')]
    public function medicalRecords(Animal $animal)
    {
        $records = $animal->medicalRecords()
            ->orderByDesc('treatment_date')
            ->get();

        return response()->json($records);
    }
}
