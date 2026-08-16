<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        return [
            'parent_id' => User::factory()->state(['role' => 'parent']),
            'name' => fake()->name(),
            'age' => fake()->numberBetween(6, 18),
            'phone_number' => fake()->phoneNumber(),
            'school' => fake()->company(),
            'academic_year' => fake()->randomElement(['السنة الأولى', 'السنة الثانية', 'السنة الثالثة', 'السنة الرابعة']),
        ];
    }
}
