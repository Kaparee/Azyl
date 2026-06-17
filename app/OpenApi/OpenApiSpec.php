<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'Azyl API',
    description: 'Publiczne API read-only dla aplikacji schroniska Azyl'
)]
#[OA\Server(
    url: L5_SWAGGER_CONST_HOST,
    description: 'Główny serwer API'
)]
class OpenApiSpec
{
}
