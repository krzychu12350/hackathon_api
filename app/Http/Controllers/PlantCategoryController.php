<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use App\Models\PlantCategory;
use Illuminate\Http\JsonResponse;

class PlantCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return $this->success(PlantCategory::all());
    }

    /**
     * Display the specified resource.
     */
    public function show(PlantCategory $category): JsonResponse
    {
        return $this->success($category);
    }
}
