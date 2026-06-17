<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "Azyl API",
    description: "Dokumentacja API dla aplikacji schroniska"
)]
#[OA\Server(
    url: L5_SWAGGER_CONST_HOST,
    description: "Główny serwer API"
)]
class AnimalController extends Controller
{
    #[OA\Get(
        path: "/api/animals",
        summary: "Pobierz listę zwierząt",
        description: "Zwraca listę wszystkich zwierząt dostępnych do adopcji wraz z informacjami o rasie i gatunku.",
        tags: ["Zwierzęta"]
    )]
    #[OA\Response(
        response: 200,
        description: "Sukces",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "current_page", type: "integer"),
                new OA\Property(
                    property: "data",
                    type: "array",
                    items: new OA\Items(
                        properties: [
                            new OA\Property(property: "id", type: "integer"),
                            new OA\Property(property: "name", type: "string"),
                            new OA\Property(property: "description", type: "string"),
                            new OA\Property(property: "age_months", type: "integer")
                        ],
                        type: "object"
                    )
                )
            ],
            type: "object"
        )
    )]
    public function index(Request $request)
    {
        $animals = Animal::with(['breed.species'])
            ->paginate(15);

        return response()->json($animals);
    }
}
