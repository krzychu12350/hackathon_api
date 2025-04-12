<?php

namespace App\Http\Controllers;

use App\Strategies\PhotoStorageStrategy\PhotoStorageStrategy;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class PhotoUploadController extends Controller
{
    protected PhotoStorageStrategy $storageStrategy;

    public function __construct(PhotoStorageStrategy $storageStrategy)
    {
        $this->storageStrategy = $storageStrategy;
    }

    public function upload(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'photo' => 'required|image|max:5120', // 5MB
        ]);

        $uploadedFileUrl = $this->storageStrategy->store($request->file('photo'));

        return response()->json([
            'success' => true,
            'url' => $uploadedFileUrl,
        ]);
    }
}
