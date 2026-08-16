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
            'paymob_order_id' => fake()->uuid(),
            'paymob_transaction_id' => fake()->uuid(),
            'status' => fake()->randomElement(['success', 'pending', 'failed']),
            'failure_reason' => null,
        ];
    }
}
