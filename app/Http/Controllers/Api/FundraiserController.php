<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fundraiser;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class FundraiserController extends Controller
{
    #[OA\Get(
        path: '/api/fundraisers',
        summary: 'Pobierz listę aktywnych zbiórek',
        description: 'Zwraca paginowaną listę zbiórek o statusie aktywnym (status = 1).',
        tags: ['Zbiórki']
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
                            new OA\Property(property: 'title', type: 'string'),
                            new OA\Property(property: 'target_amount', type: 'number', format: 'float'),
                            new OA\Property(property: 'collected_amount', type: 'number', format: 'float'),
                            new OA\Property(property: 'status', type: 'integer'),
                            new OA\Property(property: 'animal', type: 'object'),
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
        $fundraisers = Fundraiser::with(['animal.breed.species'])
            ->where('status', 1)
            ->latest()
            ->paginate(12);

        return response()->json($fundraisers);
    }

    #[OA\Get(
        path: '/api/fundraisers/{id}',
        summary: 'Pobierz szczegóły zbiórki',
        description: 'Zwraca pojedynczą zbiórkę wraz z powiązanym zwierzęciem.',
        tags: ['Zbiórki']
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
                new OA\Property(property: 'title', type: 'string'),
                new OA\Property(property: 'description', type: 'string'),
                new OA\Property(property: 'target_amount', type: 'number', format: 'float'),
                new OA\Property(property: 'collected_amount', type: 'number', format: 'float'),
                new OA\Property(property: 'status', type: 'integer'),
                new OA\Property(property: 'animal', type: 'object'),
            ],
            type: 'object'
        )
    )]
    #[OA\Response(response: 404, description: 'Nie znaleziono')]
    public function show(Fundraiser $fundraiser)
    {
        $fundraiser->load(['animal.breed.species']);

        return response()->json($fundraiser);
    }
}
