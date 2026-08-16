<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

class AdminCourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('teacher')
            ->withCount(['groups', 'subscriptions as students_count'])
            ->latest()
            ->paginate(10);

        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $teachers = User::where('role', 'teacher')->get();

        return view('admin.courses.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'monthly_fee' => ['required', 'numeric', 'min:0'],
            'teacher_id' => ['nullable', 'exists:users,id'],
            'monthly_sessions' => ['required', 'integer', 'min:1', 'max:100'],
        ]);

        Course::create($validated);

        return redirect()->route('admin.course')->with('success', 'تم إنشاء الدورة بنجاح.');
    }

    public function edit(Course $course)
    {
        $teachers = User::where('role', 'teacher')->get();

        $students = $course->subscriptions()->with('student')->get()->pluck('student')->unique('id');

        return view('admin.courses.edit', compact('course', 'teachers', 'students'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'monthly_fee' => ['required', 'numeric', 'min:0'],
            'teacher_id' => ['nullable', 'exists:users,id'],
            'monthly_sessions' => ['required', 'integer', 'min:1', 'max:100'],
        ]);

        $course->update($validated);

        return redirect()->route('admin.course')->with('success', 'تم تحديث الدورة بنجاح.');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('admin.course')->with('success', 'تم حذف الدورة بنجاح.');
    }

    public function storeGroup(Request $request, Course $course)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'schedule' => ['required', 'string', 'max:255'],
            'capacity' => ['nullable', 'integer', 'min:1'],
        ]);

        $course->groups()->create($validated);

        return back()->with('success', 'تم إنشاء المجموعة بنجاح.');
    }

    public function destroyGroup(Course $course, Group $group)
    {
        if ($group->course_id !== $course->id) {
            abort(404);
        }

        $group->delete();

        return back()->with('success', 'تم حذف المجموعة من الدورة.');
    }
}
