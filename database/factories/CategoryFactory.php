<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
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
            'picture' => fake()->imageUrl(640, 480, 'categories', true),
            'status' => fake()->randomElement(['ACTIVE', 'DISABLED', 'ARCHIVED']),
        ];
    }
}
