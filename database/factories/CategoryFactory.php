<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Electronics',
            'Clothing',
            'Home & Garden',
            'Sports & Outdoors',
            'Books & Media',
            'Beauty & Health',
            'Automotive',
            'Toys & Games',
            'Food & Beverages',
            'Jewelry & Watches'
        ];

        return [
            'name' => fake()->unique()->randomElement($categories),
        ];
    }
}
