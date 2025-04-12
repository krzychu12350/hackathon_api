<?php

namespace Database\Factories;

use App\Models\PlantCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PlantCategory>
 */
class PlantCategoryFactory extends Factory
{
    protected $model = PlantCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
//            'description' => $this->faker->optional()->sentence(),
        ];
    }
}
