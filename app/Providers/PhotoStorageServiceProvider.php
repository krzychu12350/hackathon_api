<?php

namespace App\Providers;

use App\Strategies\PhotoStorageStrategy\CloudinaryStorageStrategy;
use App\Strategies\PhotoStorageStrategy\PhotoStorageStrategy;
use Illuminate\Support\ServiceProvider;

class PhotoStorageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PhotoStorageStrategy::class, function ($app) {
            // Determine whether to use Cloudinary or local storage based on the .env file
//            if (env('PHOTO_STORAGE') === 'cloudinary') {
//                return new CloudinaryStorageStrategy();
//            }
//
//            return new LocalStorageStrategy();
            return new CloudinaryStorageStrategy();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
