<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthControllerOld;
use App\Http\Controllers\PhotoUploadController;
use App\Http\Controllers\PlantCategoryController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\TypescriptController;
use App\Http\Controllers\UserController;
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
        'data' => [1,2,3,4]
    ]);
});

//Route::prefix('auth')->group(function () {
//    Route::post('/login', [AuthControllerOld::class, 'login']);
//    Route::post('/register', [AuthControllerOld::class, 'register']);
//    Route::middleware('auth:sanctum')->post('/logout', [AuthControllerOld::class, 'logout']);
//});
//

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

//    Route::prefix('/password/reset')->group(function () {
//        Route::post('/email', [PasswordResetController::class, 'sendPasswordResetEmail']);
//        Route::post('', [PasswordResetController::class, 'resetPassword']);
//    });

    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
});


Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('users.plants', PlantController::class)->except(['update']);
    Route::post('users/{user}/plants/{plant}', [PlantController::class, 'update']);

//    Route::put('users/{user}/plants/{plant}/', [PlantController::class, 'update']);

    //parowanie


//    Route::apiResource('categories', PlantCategoryController::class)
//        ->only(['index', 'show']);

    Route::apiResource('users', UserController::class)->only('index');
});

Route::post('/upload-photo', [PhotoUploadController::class, 'upload']);
