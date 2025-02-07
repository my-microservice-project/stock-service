<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;


#[OA\Info(
    version: "1.0.0",
    description: "Stock API Documentation",
    title: "Stock Service",
    contact: new OA\Contact(email: "bugrabozkurtt@gmail.com"),
    license: new OA\License(name: "MIT", url: "https://opensource.org/licenses/MIT")
)]
abstract class Controller
{
}
