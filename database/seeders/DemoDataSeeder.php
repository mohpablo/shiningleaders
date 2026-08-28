<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\GroupStudentSession;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'demo.admin@example.com'],
            [
                'name' => 'Demo Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        $parent = User::updateOrCreate(
            ['email' => 'demo.parent@example.com'],
            [
                'name' => 'Demo Parent',
                'password' => Hash::make('password'),
                'role' => 'parent',
            ]
        );

        $teacher = User::updateOrCreate(
            ['email' => 'demo.teacher@example.com'],
            [
                'name' => 'Demo Teacher',
                'password' => Hash::make('password'),
                'role' => 'teacher',
                'teacher_share' => 50,
            ]
        );

        $math = Course::updateOrCreate(
            ['name' => 'Demo Mathematics'],
            [
                'description' => 'Demo course for payment testing.',
                'monthly_fee' => 150,
                'monthly_sessions' => 8,
                'grade' => 'Grade 5',
            ]
        );

        $science = Course::updateOrCreate(
            ['name' => 'Demo Science'],
            [
                'description' => 'Demo course with a confirmed payment.',
                'monthly_fee' => 175,
                'monthly_sessions' => 8,
                'grade' => 'Grade 6',
            ]
        );

        $pendingStudent = Student::updateOrCreate(
            ['parent_id' => $parent->id, 'name' => 'Demo Student Pending'],
            [
                'age' => 10,
                'phone_number' => '0500000001',
                'school' => 'Demo School',
                'academic_year' => 'Grade 5',
            ]
        );

        $paidStudent = Student::updateOrCreate(
            ['parent_id' => $parent->id, 'name' => 'Demo Student Paid'],
            [
                'age' => 11,
                'phone_number' => '0500000002',
                'school' => 'Demo School',
                'academic_year' => 'Grade 6',
            ]
        );

        $pendingSubscription = $pendingStudent->subscriptions()->updateOrCreate(
            ['course_id' => $math->id],
            [
                'parent_id' => $parent->id,
                'status' => 'pending',
                'valid_until' => now()->addMonth(),
                'sessions_used' => 0,
                'sessions_limit' => 8,
            ]
        );

        $paidSubscription = $paidStudent->subscriptions()->updateOrCreate(
            ['course_id' => $science->id],
            [
                'parent_id' => $parent->id,
                'status' => 'active',
                'valid_until' => now()->addMonth(),
                'sessions_used' => 2,
                'sessions_limit' => 8,
            ]
        );

        $mathGroup = $math->groups()->updateOrCreate(
            ['name' => 'Demo Mathematics Group'],
            [
                'teacher_id' => $teacher->id,
                'schedule' => 'Monday and Wednesday 5-7 PM',
            ]
        );

        $scienceGroup = $science->groups()->updateOrCreate(
            ['name' => 'Demo Science Group'],
            [
                'teacher_id' => $teacher->id,
                'schedule' => 'Tuesday and Thursday 4-6 PM',
            ]
        );

        $mathGroup->students()->syncWithoutDetaching([$pendingStudent->id]);
        $scienceGroup->students()->syncWithoutDetaching([$paidStudent->id]);

        $mathGroup->update(['sessions_completed' => 2]);
        $scienceGroup->update(['sessions_completed' => 2]);

        $mathSessionOne = GroupStudentSession::updateOrCreate(
            ['group_id' => $mathGroup->id, 'student_id' => $pendingStudent->id, 'session_number' => 1],
            ['attendance' => true, 'homework_status' => 'completed', 'comment' => 'أداء ممتاز في التمارين.']
        );
        $mathSessionOne->update(['created_at' => now()->subDays(14)]);

        $mathSessionTwo = GroupStudentSession::updateOrCreate(
            ['group_id' => $mathGroup->id, 'student_id' => $pendingStudent->id, 'session_number' => 2],
            ['attendance' => true, 'homework_status' => 'partial', 'comment' => 'أنجز نصف الواجب ويحتاج إلى إكمال الباقي.']
        );
        $mathSessionTwo->update(['created_at' => now()->subDays(7)]);

        $scienceSessionOne = GroupStudentSession::updateOrCreate(
            ['group_id' => $scienceGroup->id, 'student_id' => $paidStudent->id, 'session_number' => 1],
            ['attendance' => false, 'homework_status' => 'not_completed', 'comment' => 'غائب عن الجلسة.']
        );
        $scienceSessionOne->update(['created_at' => now()->subDays(12)]);

        $scienceSessionTwo = GroupStudentSession::updateOrCreate(
            ['group_id' => $scienceGroup->id, 'student_id' => $paidStudent->id, 'session_number' => 2],
            ['attendance' => true, 'homework_status' => 'completed', 'comment' => 'تحسن واضح في المشاركة.']
        );
        $scienceSessionTwo->update(['created_at' => now()->subDays(5)]);

        $pendingSubscription->payments()->updateOrCreate(
            ['status' => 'pending'],
            ['amount' => 150, 'failure_reason' => null]
        );

        $paidSubscription->payments()->updateOrCreate(
            ['status' => 'success'],
            ['amount' => 175, 'failure_reason' => null]
        );
    }
}
