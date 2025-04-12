<?php

namespace Database\Factories;

use App\Enums\PlantWaterAmount;
use App\Models\Plant;
use App\Models\PlantCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plant>
 */
class PlantFactory extends Factory
{
    protected $model = Plant::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'plant_category_id' => PlantCategory::factory(), // associate with a category
            'preferred_water_amount' => $this->faker->randomElement(array_column(PlantWaterAmount::cases(), 'value')),
            'description' => $this->faker->optional()->paragraph(),
            'location' => $this->faker->randomElement(['outside', 'inside']),
            'user_id' => User::factory(), // associate with a user
        ];
    }
}
