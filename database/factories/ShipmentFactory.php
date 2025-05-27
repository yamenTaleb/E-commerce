<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\shipment>
 */
class ShipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'shipment_date' => fake()->dateTimeBetween('-1 year', '-1 month'),
            'delivery_date' => fake()->dateTimeBetween('-1 month', '+1 month'),
            'shipment_status' => fake()->randomElement(['shipped', 'delivered', 'cancelled']),
        ];
    }
}
