<?php

namespace Database\Seeders;

use App\Enums\FileType;
use App\Models\File;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PlantCategory;
use App\Models\Plant;

class PlantDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        // Create 5 plant categories
//        $categories = PlantCategory::factory()
//            ->count(5)  // You can adjust the number of categories here
//            ->create();
//
//        // Create 5 users
//        User::factory()
//            ->count(5)  // Create 5 users
//            ->create()
//            ->each(function ($user) use ($categories) {
//                // Set the password for each user to "securePassword12?3"
//                $user->update([
//                    'password' => bcrypt('securePassword12?3'), // Hash the password
//                ]);
//
//                // For each user, create 20 plants and assign random categories
//                Plant::factory()
//                    ->count(20)  // 20 plants per user
//                    ->state(function (array $attributes) use ($user, $categories) {
//                        return [
//                            'user_id' => $user->id,  // Assign plants to the created user
//                            'plant_category_id' => $categories->random()->id  // Assign a random category from the created categories
//                        ];
//                    })
//                    ->create();
//            });

        $file = File::create([
            'url' => 'https://res.cloudinary.com/dysdefjin/image/upload/v1744494928/plant_photos/zsxguhi93lhfkdttyurc.jpg',
            'type' => FileType::IMAGE,
        ]);

        // Create 5 users
        User::factory()
            ->count(5)  // Create 5 users
            ->create()
            ->each(function ($user) use ($file) {
                // Set the password for each user to "securePassword12?3"
                $user->update([
                    'password' => bcrypt('securePassword12?3'), // Hash the password
                ]);

                // For each user, create 20 plants
                Plant::factory()
                    ->count(20)  // 20 plants per user
                    ->state(function (array $attributes) use ($user, $file) {
                        return [
                            'user_id' => $user->id,  // Assign plants to the created user
                            'file_id' => $file->id,
                        ];
                    })
                    ->create();
            });
        // Also create 20 plants for the user with ID 1
        $user = User::find(1);
        if ($user) {
            $user->update([
                'password' => bcrypt('securePassword12?3'),
            ]);

            Plant::factory()
                ->count(20)
                ->state(function (array $attributes) use ($file, $user) {
                    return [
                        'user_id' => $user->id,
                        'file_id' => $file->id,
                    ];
                })
                ->create();
        }


    }
}
