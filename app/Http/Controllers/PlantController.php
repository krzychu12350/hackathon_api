<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Plant;
use App\Http\Requests\StorePlantRequest;
use App\Http\Requests\UpdatePlantRequest;
use App\Enums\PlantWaterAmount;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlantController extends Controller
{
    public function index(Request $request, User $user): JsonResponse
    {
        $user = request()->user();

        // Get only this user's plants
        $plants = $user->plants()->with('category')->get();

        return $this->success($plants);
    }

    public function store(StorePlantRequest $request, User $user): JsonResponse
    {
        $validated = $request->validated();
        $user = request()->user();

        $validated['preferred_water_amount'] = PlantWaterAmount::from($validated['preferred_water_amount']);

        $plant = $user->plants()->create($validated);

        return $this->success($plant->load('category'), 201);
    }

    public function show(User $user, Plant $plant): JsonResponse
    {
        return $this->success($plant->load('category'));
    }

    public function update(UpdatePlantRequest $request, User $user, Plant $plant): JsonResponse
    {
        $validated = $request->validated();

        if (isset($validated['preferred_water_amount'])) {
            $validated['preferred_water_amount'] = PlantWaterAmount::from($validated['preferred_water_amount']);
        }

        $plant->update($validated);

        return $this->success($plant->load('category'));
    }

    public function destroy(User $user, Plant $plant): JsonResponse
    {
        $user = request()->user();

        // Check if the plant belongs to the user
        if ($plant->user_id !== $user->id) {
            abort(403, 'This plant does not belong to the specified user.');
        }

        $plant->delete();

        return $this->noContent();
    }
}
