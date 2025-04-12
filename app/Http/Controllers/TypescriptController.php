<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TypescriptController extends Controller
{
    /**
     * Run the typegen script and return the generated TypeScript file to the user.
     */
    public function downloadFormRequests(): BinaryFileResponse
    {
        // Run the typegen script to generate form request types
       // $this->runTypegenScript();

        // Path to the generated TypeScript file
        $path = resource_path('js/types/formRequests.ts');

        // Check if the file exists after running the script
        if (!file_exists($path)) {
            abort(404, 'File not found.');
        }

        // Return the generated TypeScript file as a download response
        return Response::download($path, 'formRequests.ts', [
            'Content-Type' => 'text/plain',
        ]);
    }

    /**
     * Run the typegen command to generate TypeScript types for form requests.
     */
    private function runTypegenScript(): void
    {
        // Run the laravel-typegen script using PHP's exec() function
        $output = null;
        $resultCode = null;

        // Running the typegen command
        exec('npm run typegen', $output, $resultCode);

        // Check if the command was successful
        if ($resultCode !== 0) {
            abort(500, 'Error generating TypeScript types: ' . implode("\n", $output));
        }
    }
}
