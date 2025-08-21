<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'thumbnail' => 'https://picsum.photos/400/300?random=' . fake()->numberBetween(1, 1000),
            'title' => fake()->sentence(3, 6),
            'description' => fake()->paragraphs(2, true),
            'quantity' => fake()->numberBetween(1, 100),
            'price' => fake()->randomFloat(2, 10, 1000),
            'category_id' => Category::factory(),
            'user_id' => User::factory(),
        ];
    }

    /**
     * Indicate that the post is in stock.
     */
    public function inStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'quantity' => fake()->numberBetween(10, 100),
        ]);
    }

    /**
     * Indicate that the post is low in stock.
     */
    public function lowStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'quantity' => fake()->numberBetween(1, 9),
        ]);
    }

    /**
     * Indicate that the post is out of stock.
     */
    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'quantity' => 0,
        ]);
    }

    /**
     * Indicate that the post is expensive.
     */
    public function expensive(): static
    {
        return $this->state(fn (array $attributes) => [
            'price' => fake()->randomFloat(2, 500, 5000),
        ]);
    }

    /**
     * Indicate that the post is affordable.
     */
    public function affordable(): static
    {
        return $this->state(fn (array $attributes) => [
            'price' => fake()->randomFloat(2, 10, 100),
        ]);
    }
}
