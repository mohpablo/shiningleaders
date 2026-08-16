<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Group;
use App\Models\payment;
use App\Models\Student;
use App\Models\subscription;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin1',
            'email' => 'admin1@gmail.com',
            'password' => '123456789',
            'role' => 'admin',
        ]);

        $seededTeacher = User::factory()->teacher()->create([
            'name' => 'Teacher1',
            'email' => 'teacher1@gmail.com',
            'password' => '123456789',
            'role' => 'teacher',
            'teacher_share' => 20,
        ]);

        $teachers = User::factory()->count(3)->teacher()->create()->push($seededTeacher);

        $parents = User::factory()->count(12)->parent()->create();

        $courses = Course::factory()->count(6)->state(function () use ($teachers) {
            return [
                'teacher_id' => $teachers->random()->id,
            ];
        })->create();

        $students = Student::factory()->count(40)->state(function () use ($parents) {
            return [
                'parent_id' => $parents->random()->id,
            ];
        })->create();

        $groups = Group::factory()->count(10)->state(function () use ($courses) {
            return [
                'course_id' => $courses->random()->id,
            ];
        })->create();

        foreach ($groups as $group) {
            $group->students()->attach(
                $students->random(rand(4, 12))->pluck('id')->toArray(),
                ['enrollment_date' => now()->subDays(rand(1, 60))]
            );
        }

        $subscriptions = subscription::factory()->count(50)->state(function () use ($students, $courses) {
            $student = $students->random();
            return [
                'student_id' => $student->id,
                'course_id' => $courses->random()->id,
                'parent_id' => $student->parent_id,
                'status' => fake()->randomElement(['active', 'pending', 'expired']),
                'valid_until' => now()->addDays(rand(-30, 30)),
            ];
        })->create();

        payment::factory()->count(60)->state(function () use ($subscriptions) {
            $subscription = $subscriptions->random();
            $amount = $subscription->course->monthly_fee;
            return [
                'subscription_id' => $subscription->id,
                'amount' => $amount,
                'status' => fake()->randomElement(['success', 'pending', 'failed']),
            ];
        })->create();
    }
}
