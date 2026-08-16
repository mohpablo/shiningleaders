<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Group;
use App\Models\Student;
use App\Models\subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    public function dashboard()
    {
        $teacher = Auth::user();

        $courses = $teacher->courses()
            ->withCount('groups')
            ->withCount(['subscriptions as students_count'])
            ->get();

        $earnings = $courses->flatMap(function ($course) {
            return $course->subscriptions->flatMap->payments;
        })->where('status', 'success')
            ->sum(function ($payment) use ($teacher) {
                return $payment->amount * ($teacher->teacher_share / 100);
            });

        $totalGroups = $courses->sum('groups_count');
        $totalStudents = $courses->sum('students_count');

        return view('teacher.dashboard', compact('courses', 'earnings', 'totalGroups', 'totalStudents'));
    }

    public function courses()
    {
        $courses = Auth::user()->courses()
            ->withCount('groups')
            ->withCount(['subscriptions as students_count'])
            ->paginate(12);

        return view('teacher.courses', compact('courses'));
    }

    public function showCourse(Course $course)
    {
        $this->authorizeTeacherCourse($course);

        $groups = $course->groups()->withCount('students')->get();
        $students = Student::whereHas('subscriptions', function ($query) use ($course) {
            $query->where('course_id', $course->id);
        })->with('parent')->get();

        return view('teacher.course', compact('course', 'groups', 'students'));
    }

    public function showGroup(Course $course, Group $group)
    {
        $this->authorizeTeacherCourse($course);

        if ($group->course_id !== $course->id) {
            abort(404);
        }

        $students = $group->students()->with('parent')->get();

        return view('teacher.group', compact('course', 'group', 'students'));
    }

    public function completeSession(Course $course, Group $group)
    {
        $this->authorizeTeacherCourse($course);

        if ($group->course_id !== $course->id) {
            abort(404);
        }

        $group->increment('sessions_completed');

        $studentIds = $group->students()->pluck('students.id')->toArray();

        $subscriptions = subscription::where('course_id', $course->id)
            ->whereIn('student_id', $studentIds)
            ->where('status', 'active')
            ->get();

        foreach ($subscriptions as $subscription) {
            if ($subscription->sessions_limit === null || $subscription->sessions_used < $subscription->sessions_limit) {
                $subscription->increment('sessions_used');
            }
        }

        return redirect()->route('teacher.courses.groups.show', [$course, $group])
            ->with('success', 'تم تسجيل الجلسة المنفذة بنجاح.');
    }

    public function markStudent(Request $request, Course $course, Group $group, Student $student)
    {
        $this->authorizeTeacherCourse($course);

        if ($group->course_id !== $course->id) {
            abort(404);
        }

        if (! $group->students()->where('student_id', $student->id)->exists()) {
            abort(404);
        }

        $validated = $request->validate([
            'attendance' => ['nullable', 'boolean'],
            'homework_completed' => ['nullable', 'boolean'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $group->students()->syncWithoutDetaching([
            $student->id => [
                'attendance' => boolval($validated['attendance'] ?? false),
                'homework_completed' => boolval($validated['homework_completed'] ?? false),
                'comment' => trim($validated['comment'] ?? '') ?: null,
            ],
        ]);

        return redirect()->route('teacher.courses.groups.show', [$course, $group])
            ->with('success', 'تم تحديث حالة الطالب بنجاح.');
    }

    protected function authorizeTeacherCourse(Course $course)
    {
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }
    }
}
