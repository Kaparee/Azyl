<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use OpenApi\Attributes as OA;

class NewsController extends Controller
{
    #[OA\Get(
        path: '/api/news',
        summary: 'Pobierz listę opublikowanych aktualności',
        description: 'Zwraca paginowaną listę aktualności z flagą is_published = true.',
        tags: ['Aktualności']
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
                            new OA\Property(property: 'published_at', type: 'string', format: 'date-time'),
                        ],
                        type: 'object'
                    )
                ),
            ],
            type: 'object'
        )
    )]
    public function index()
    {
        $news = News::where('is_published', true)
            ->latest('published_at')
            ->paginate(12);

        return response()->json($news);
    }

    #[OA\Get(
        path: '/api/news/{id}',
        summary: 'Pobierz szczegóły aktualności',
        description: 'Zwraca pojedynczy opublikowany artykuł.',
        tags: ['Aktualności']
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
                new OA\Property(property: 'content', type: 'string'),
                new OA\Property(property: 'published_at', type: 'string', format: 'date-time'),
            ],
            type: 'object'
        )
    )]
    #[OA\Response(response: 404, description: 'Nie znaleziono')]
    public function show(News $news)
    {
        if (! $news->is_published) {
            abort(404);
        }

        return response()->json($news);
    }
}
