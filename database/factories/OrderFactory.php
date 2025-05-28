<?php

namespace Database\Factories;

use App\Enums\OrderStatusEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $orderDate = $this->faker->dateTimeBetween('now', '+1 year');

        return [
            'user_id' => User::factory(),
            'order_date' => $orderDate,
            'status' => $this->faker->randomElement([
                OrderStatusEnum::PENDING->value,
                OrderStatusEnum::PAID->value,
                OrderStatusEnum::SHIPPED->value,
                OrderStatusEnum::DELIVERED->value,
                OrderStatusEnum::CANCELED->value,
                OrderStatusEnum::REFUNDED->value,
            ]),
            'session_id' => 'sess_' . $this->faker->uuid,
            'total' => $this->faker->numberBetween(2, 999),
        ];
    }
}
