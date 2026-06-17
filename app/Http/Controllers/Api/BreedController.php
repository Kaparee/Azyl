<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Breed;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class BreedController extends Controller
{
    #[OA\Get(
        path: '/api/breeds',
        summary: 'Pobierz listę ras',
        description: 'Zwraca listę ras; opcjonalnie filtruje po species_id.',
        tags: ['Słowniki']
    )]
    #[OA\Parameter(
        name: 'species_id',
        in: 'query',
        required: false,
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
                    new OA\Property(property: 'name', type: 'string'),
                    new OA\Property(property: 'species_id', type: 'integer'),
                    new OA\Property(property: 'species', type: 'object'),
                ],
                type: 'object'
            )
        )
    )]
    public function index(Request $request)
    {
        $query = Breed::with('species')->orderBy('name');

        if ($request->filled('species_id')) {
            $query->where('species_id', $request->species_id);
        }

        return response()->json($query->get());
    }
}
