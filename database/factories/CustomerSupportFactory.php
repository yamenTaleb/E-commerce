<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CustomerSupport>
 */
class CustomerSupportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => User::factory(),
            'product_id' => Product::factory(),
            'subject' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(['pending', 'considered', 'solved'])
        ];
    }
}
