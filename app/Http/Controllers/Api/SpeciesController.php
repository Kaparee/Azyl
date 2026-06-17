<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Species;
use OpenApi\Attributes as OA;

class SpeciesController extends Controller
{
    #[OA\Get(
        path: '/api/species',
        summary: 'Pobierz listę gatunków',
        description: 'Zwraca wszystkie gatunki zwierząt zarejestrowane w systemie.',
        tags: ['Słowniki']
    )]
    #[OA\Response(
        response: 200,
        description: 'Sukces',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(
                properties: [
                    new OA\Property(property: 'id', type: 'integer'),
                    new OA\Property(property: 'name', type: 'string'),
                ],
                type: 'object'
            )
        )
    )]
    public function index()
    {
        $species = Species::orderBy('name')->get();

        return response()->json($species);
    }
}
