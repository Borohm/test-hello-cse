<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'price' => fake()->randomFloat(2, 1, 100),
            'picture' => fake()->uuid() . '.jpg',
            'status' => fake()->randomElement(['active', 'draft', 'disabled']),
            'category_id' => Category::factory(),
        ];
    }
}
