<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[
    OA\Info(
        title: "Test HelloCSE API",
        version: "1.0.0",
        description: "API for the HelloCSE test"
    )
]
abstract class Controller
{
    //
}
