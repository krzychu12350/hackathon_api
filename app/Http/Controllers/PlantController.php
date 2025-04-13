<?php

namespace App\Http\Controllers;

use App\Enums\FileType;
use App\Http\Controllers\Controller;
use App\Http\Resources\PlantResource;
use App\Models\File;
use App\Models\Plant;
use App\Http\Requests\StorePlantRequest;
use App\Http\Requests\UpdatePlantRequest;
use App\Enums\PlantWaterAmount;
use App\Models\User;
use App\Strategies\PhotoStorageStrategy\PhotoStorageStrategy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlantController extends Controller
{
    protected PhotoStorageStrategy $storageStrategy;

    public function __construct(PhotoStorageStrategy $storageStrategy)
    {
        $this->storageStrategy = $storageStrategy;
    }

    public function index(Request $request, User $user): JsonResponse
    {
        $user = request()->user();

        //'category',
        // Get only this user's plants
        $plants = $user->plants()->with([ 'photo'])->latest()->get();

        return $this->success(PlantResource::collection($plants));
    }

    public function store(StorePlantRequest $request, User $user): JsonResponse
    {
        $validated = $request->validated();

        $user = request()->user();

        $file = $request->file('photo');
        $url = '';

        // Handle file upload
        if ($file) {
            $url = $this->storageStrategy->store($request->file('photo'));
        }

        // Create a new file record in the `files` table
        $file = File::create([
            'url' => $url,
            'type' => FileType::IMAGE,
        ]);

//        $validated['preferred_water_amount'] = PlantWaterAmount::from($validated['preferred_water_amount']);

        $plant = $user->plants()->create($validated);

        // Attach the file to the user via the pivot table
        $plant->file_id = $file->id;
        $plant->save();

        return $this->created(new PlantResource($plant), 201);
    }

    public function show(User $user, Plant $plant): JsonResponse
    {
        return $this->success(new PlantResource($plant));
    }

    public function update(UpdatePlantRequest $request, User $user, Plant $plant): JsonResponse
    {
        $validated = $request->validated();

        // Handle file upload (if a new photo is uploaded)
        $file = $request->file('photo');
        $url = $plant->photo ? $plant->photo->url : ''; // Keep the current photo URL if no new photo is uploaded

        // Only upload the new photo if a file is provided
        if ($file) {
            // Handle the file upload via the storage strategy
            $url = $this->storageStrategy->store($file);

            // Create a new file record in the `files` table
            $newFile = File::create([
                'url' => $url,
                'type' => FileType::IMAGE,
            ]);

            // Delete the old photo file (if exists) from the storage system
            if ($plant->file_id) {
                $oldFile = File::find($plant->file_id);
                if ($oldFile) {
                    // Assuming a `delete` method is implemented in the storage strategy to delete the file
                    $this->storageStrategy->remove($oldFile->url);
                    $oldFile->delete();
                }
            }

            // Attach the new file to the plant
            $plant->file_id = $newFile->id;
        }

        // Update the plant with the validated data
        $plant->update($validated);

        // Return the updated plant resource, including the associated category and photo
        return $this->success($plant->load(['photo']), 200);
    }

    public function destroy(User $user, Plant $plant): JsonResponse
    {
        $user = request()->user();

        // Check if the plant belongs to the user
        if ($plant->user_id !== $user->id) {
            abort(403, 'This plant does not belong to the specified user.');
        }

        // Remove the photo file and DB record if it exists
        if ($plant->file_id) {
            $file = $plant->photo; // Assuming 'photo' is the relation to File model

            if ($file) {
                // Delete from storage
                $this->storageStrategy->remove($file->url);

                // Delete from DB
                $file->delete();
            }
        }

        // Delete the plant
        $plant->delete();

        return $this->noContent();
    }

}
