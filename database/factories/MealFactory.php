<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Meal>
 */
class MealFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
          'name' => fake()->name,
          'description' => fake()->sentence(),
          'price' => fake()->randomFloat(2, 1, 100),
          'image' => fake()->imageUrl(640, 480, 'food', true, 'meal'),
        ];
    }
}
