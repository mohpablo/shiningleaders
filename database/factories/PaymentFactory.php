<?php

namespace Database\Factories;

use App\Models\payment;
use App\Models\subscription;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<payment>
 */
class PaymentFactory extends Factory
{
    protected $model = payment::class;

    public function definition(): array
    {
        return [
            'subscription_id' => subscription::factory(),
            'amount' => fake()->randomFloat(2, 50, 250),
            'status' => fake()->randomElement(['success', 'pending', 'failed']),
            'failure_reason' => null,
        ];
    }
}
