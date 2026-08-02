<?php

namespace App\Http\Controllers;
use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'ApiLab Documentation'
)]
#[OA\Schema(
    schema: '403ResponseSchema',
    properties: [
        new OA\Property(property: 'message',type: 'string',example: 'Access denied')
    ]
)]
abstract class Controller
{
    //
}
