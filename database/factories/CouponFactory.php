<?php

namespace Database\Factories;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement([
            Coupon::TYPE_FIXED,
            Coupon::TYPE_PERCENT,
        ]);

        $discountAmount = $type === Coupon::TYPE_PERCENT
            ? $this->faker->numberBetween(5, 50) // 5% to 50%
            : $this->faker->randomFloat(2, 5, 200); // $5 to $200

        return [
            'name' => $this->faker->words(3, true) . ' Coupon',
            'code' => strtoupper(Str::random(8)),
            'type' => $type,
            'discount_amount' => $discountAmount,
            'min_purchase' => $this->faker->boolean(70)
                ? $this->faker->randomFloat(2, 20, 200)
                : null,
            'usage_limit' => $this->faker->boolean(60)
                ? $this->faker->numberBetween(10, 1000)
                : null,
            'is_active' => $this->faker->boolean(90), // 90% chance of being active
            'starts_at' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'expires_at' => $this->faker->dateTimeBetween('+1 month', '+1 year'),
        ];
    }

    /**
     * Indicate that the coupon is a fixed amount discount.
     */
    public function fixed(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => Coupon::TYPE_FIXED,
            'discount_amount' => $this->faker->randomFloat(2, 5, 200),
        ]);
    }

    /**
     * Indicate that the coupon is a percentage discount.
     */
    public function percent(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => Coupon::TYPE_PERCENT,
            'discount_amount' => $this->faker->numberBetween(5, 50),
        ]);
    }

    /**
     * Indicate that the coupon is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
            'starts_at' => now()->subDay(),
            'expires_at' => now()->addMonth(),
        ]);
    }

    /**
     * Indicate that the coupon is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Indicate that the coupon has expired.
     */
    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'starts_at' => now()->subMonths(2),
            'expires_at' => now()->subMonth(),
        ]);
    }

    /**
     * Indicate that the coupon is not yet active.
     */
    public function upcoming(): static
    {
        return $this->state(fn (array $attributes) => [
            'starts_at' => now()->addWeek(),
            'expires_at' => now()->addMonth(),
        ]);
    }
}
