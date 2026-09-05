<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupStudentSession;
use App\Models\Student;
use App\Models\subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    public function dashboard()
    {
        $teacher = Auth::user();

        $groups = Group::where('teacher_id', $teacher->id)
            ->with(['course', 'students'])
            ->get();

        $studentIds = $groups->flatMap->students->pluck('id')->unique();
        $courseIds = $groups->pluck('course_id')->unique();
        $assignedPairs = $groups->flatMap(fn ($group) => $group->students->map(
            fn ($student) => $group->course_id . ':' . $student->id
        ));

        $earnings = Subscription::whereIn('course_id', $courseIds)
            ->whereIn('student_id', $studentIds)
            ->with('payments')
            ->get()
            ->filter(fn ($subscription) => $assignedPairs->contains(
                $subscription->course_id . ':' . $subscription->student_id
            ))
            ->flatMap->payments
            ->where('status', 'success')
            ->sum(function ($payment) use ($teacher) {
                return $payment->amount * ($teacher->teacher_share / 100);
            });

        $totalGroups = $groups->count();
        $totalStudents = $studentIds->count();

        return view('teacher.dashboard', compact('groups', 'earnings', 'totalGroups', 'totalStudents'));
    }

    public function groups()
    {
        $groups = Group::where('teacher_id', Auth::id())
            ->with(['course', 'students'])
            ->paginate(12);

        $groups->getCollection()->each(fn (Group $group) => $group->setAttribute(
            'students_count',
            $group->students->count()
        ));

        return view('teacher.groups', compact('groups'));
    }

    public function showGroup(Group $group)
    {
        $this->authorizeTeacherGroup($group);
        $course = $group->course;

        $students = $group->students()->with(['parent', 'sessionRecords' => fn ($query) => $query->latest('session_number')])->get();
        $currentSession = $group->sessions_completed + 1;

        return view('teacher.group', compact('course', 'group', 'students', 'currentSession'));
    }

    public function completeSession(Group $group)
    {
        $this->authorizeTeacherGroup($group);
        $course = $group->course;

        $group->increment('sessions_completed');

        $studentIds = $group->students()->pluck('students.id')->toArray();

        $subscriptions = Subscription::where('course_id', $course->id)
            ->whereIn('student_id', $studentIds)
            ->where('status', 'active')
            ->get();

        foreach ($subscriptions as $subscription) {
            if ($subscription->sessions_limit === null || $subscription->sessions_used < $subscription->sessions_limit) {
                $subscription->increment('sessions_used');
            }
        }

        return redirect()->route('teacher.groups.show', $group)
            ->with('success', 'تم تسجيل الجلسة المنفذة بنجاح.');
    }

    public function markStudent(Request $request, Group $group, Student $student)
    {
        $this->authorizeTeacherGroup($group);
        $course = $group->course;

        if (! $group->students()->where('student_id', $student->id)->exists()) {
            abort(404);
        }

        $validated = $request->validate([
            'attendance' => ['required', 'boolean'],
            'homework_status' => ['required', 'in:completed,partial,not_completed'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        GroupStudentSession::updateOrCreate(
            [
                'group_id' => $group->id,
                'student_id' => $student->id,
                'session_number' => $group->sessions_completed + 1,
            ],
            [
                'attendance' => $validated['attendance'],
                'homework_status' => $validated['homework_status'],
                'comment' => trim($validated['comment'] ?? '') ?: null,
            ]
        );

        return redirect()->route('teacher.groups.show', $group)
            ->with('success', 'تم تحديث حالة الطالب بنجاح.');
    }

    protected function authorizeTeacherGroup(Group $group)
    {
        if ($group->teacher_id !== Auth::id()) {
            abort(403);
        }
    }
}
