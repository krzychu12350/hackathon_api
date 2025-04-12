<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TypescriptController extends Controller
{
    public function downloadFormRequests(): BinaryFileResponse
    {
        $path = resource_path('js/types/formRequests.ts');

        if (!file_exists($path)) {
            abort(404, 'File not found.');
        }

        return Response::download($path, 'formRequest.ts', [
            'Content-Type' => 'text/plain',
        ]);
    }
}
