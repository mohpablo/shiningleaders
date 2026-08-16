<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Group>
 */
class GroupFactory extends Factory
{
    protected $model = Group::class;

    public function definition(): array
    {
        return [
            'course_id' => Course::factory(),
            'name' => fake()->randomElement(['مجموعة أ', 'مجموعة ب', 'مجموعة ج', 'مجموعة د']),
            'schedule' => fake()->randomElement(['الاثنين والأربعاء 5-7 مساءً', 'الثلاثاء والخميس 4-6 مساءً', 'الجمعة 10-12 صباحاً']),
            'capacity' => fake()->numberBetween(10, 24),
            'sessions_completed' => fake()->numberBetween(0, 3),
        ];
    }
}
