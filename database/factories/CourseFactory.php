<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Course>
 */
class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition(): array
    {
        return [
            'teacher_id' => User::factory()->state(['role' => 'teacher']),
            'name' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'monthly_fee' => fake()->randomFloat(2, 50, 200),
            'monthly_sessions' => fake()->numberBetween(4, 16),
        ];
    }
}
