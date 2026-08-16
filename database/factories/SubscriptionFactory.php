<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Student;
use App\Models\subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<subscription>
 */
class SubscriptionFactory extends Factory
{
    protected $model = subscription::class;

    public function definition(): array
    {
        $student = Student::factory();
        return [
            'student_id' => $student,
            'course_id' => Course::factory(),
            'parent_id' => User::factory()->state(['role' => 'parent']),
            'status' => fake()->randomElement(['active', 'pending', 'expired']),
            'valid_until' => fake()->dateTimeBetween('-30 days', '+30 days')->format('Y-m-d'),
            'sessions_used' => fake()->numberBetween(0, 8),
            'sessions_limit' => fake()->numberBetween(4, 16),
        ];
    }
}
