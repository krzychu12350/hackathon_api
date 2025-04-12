<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TypescriptController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/types', [TypescriptController::class, 'downloadFormRequests']);

Route::get('/health', function (Request $request) {
    return response()->json([
        'status' => 'ok',
        'message' => 'good',
        'data' => []
    ]);
});

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
});
