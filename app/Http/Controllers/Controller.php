<?php

namespace App\Http\Controllers;

use App\Traits\Responsable;
use Illuminate\Http\JsonResponse;

abstract class Controller
{
    use Responsable;
}
