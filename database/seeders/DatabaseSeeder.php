<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Amando Boom',
            'email' => 'test@gmail.com',
            'password' => bcrypt('securePassword12?3'),
            'role' => 'user',
        ]);

        $this->call([
            PlantDataSeeder::class,
        ]);
    }
}
