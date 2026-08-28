<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Group;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminCourseController extends Controller
{
  public function index(Request $request)
{
    $search = trim($request->string('q')->toString());

    $courses = Course::withCount('groups')
        ->withCount([
            'students as direct_students_count',
            // Count unique students linked via groups
            'groups as group_students_count' => function ($query) {
                $query->join('group_student', 'groups.id', '=', 'group_student.group_id');
            }
        ])
        ->with(['students', 'groups.students'])
        ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('grade', 'like', "%{$search}%");
        }))
        ->latest()
        ->paginate(10);

    // Calculate total unique students combining direct course enrollment + group enrollment
    $courses->getCollection()->transform(function (Course $course) {
        $directStudents = $course->students;
        $groupStudents  = $course->groups->flatMap->students;

        $course->total_students_count = $directStudents->merge($groupStudents)->unique('id')->count();

        return $course;
    });

    return view('admin.courses.index', compact('courses'));
}

    public function create()
    {
        // Define the grades to match what the parents see
        $grades = [
            'Pre-KG',
            'KG 1',
            'KG 2',
            'Grade 1',
            'Grade 2',
            'Grade 3',
            'Grade 4',
            'Grade 5',
            'Grade 6',
            'Grade 7',
            'Grade 8',
            'Grade 9',
            'Grade 10'
        ];

        return view('admin.courses.create', compact('grades'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'grade' => ['required', 'string', 'max:255'], // Added grade validation
            'monthly_fee' => ['required', 'numeric', 'min:0'],
            'monthly_sessions' => ['required', 'integer', 'min:1', 'max:100'],
        ]);

        Course::create($validated);

        return redirect()->route('admin.course')->with('success', 'تم إنشاء الدورة بنجاح.');
    }

    public function edit(Course $course)
    {
        $teacherSearch = trim(request('teacher_q', ''));
        $studentSearch = trim(request('student_q', ''));
        $teachers = User::where('role', 'teacher')
            ->when($teacherSearch !== '', fn ($query) => $query->where(function ($query) use ($teacherSearch) {
                $query->where('name', 'like', "%{$teacherSearch}%")
                    ->orWhere('email', 'like', "%{$teacherSearch}%");
            }))
            ->orderBy('name')
            ->paginate(8, ['*'], 'teacher_page')
            ->withQueryString();
        $students = Student::where(function ($query) use ($course) {
            $query->whereHas('courses', fn ($courseQuery) => $courseQuery->whereKey($course->id))
                ->orWhereHas('subscriptions', fn ($subscriptionQuery) => $subscriptionQuery->where('course_id', $course->id))
                ->orWhereHas('groups', fn ($groupQuery) => $groupQuery->where('course_id', $course->id));
        })->when($studentSearch !== '', fn ($query) => $query->where(function ($query) use ($studentSearch) {
            $query->where('students.name', 'like', "%{$studentSearch}%")
                ->orWhereHas('parent', fn ($parentQuery) => $parentQuery
                    ->where('name', 'like', "%{$studentSearch}%")
                    ->orWhere('email', 'like', "%{$studentSearch}%"));
        }))->with([
            'parent',
            'subscriptions' => fn ($query) => $query
                ->where('course_id', $course->id)
                ->with('payments'),
        ])->orderBy('name')->paginate(8, ['*'], 'student_page')->withQueryString();

        // مصفوفة الصفوف الدراسية
        $grades = [
            'Pre-KG',
            'KG 1',
            'KG 2',
            'Grade 1',
            'Grade 2',
            'Grade 3',
            'Grade 4',
            'Grade 5',
            'Grade 6',
            'Grade 7',
            'Grade 8',
            'Grade 9',
            'Grade 10'
        ];

        // إضافة 'grades' داخل compact
        return view('admin.courses.edit', compact('course', 'teachers', 'students', 'grades', 'teacherSearch', 'studentSearch'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'monthly_fee' => ['required', 'numeric', 'min:0'],
            'grade' => ['required', 'string', 'max:255'], // Added grade validation
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
            'teacher_id' => ['required', Rule::exists('users', 'id')->where(fn($query) => $query->where('role', 'teacher'))],
            'student_ids' => ['nullable', 'array'],
            'student_ids.*' => ['integer', 'exists:students,id'],
        ]);

        $group = $course->groups()->create([
            'name' => $validated['name'],
            'schedule' => $validated['schedule'],
            'teacher_id' => $validated['teacher_id'],
        ]);
        $this->syncGroupStudents($course, $group, $validated['student_ids'] ?? []);

        return back()->with('success', 'تم إنشاء المجموعة بنجاح.');
    }

    public function updateGroup(Request $request, Course $course, Group $group)
    {
        if ($group->course_id !== $course->id) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'schedule' => ['required', 'string', 'max:255'],
            'teacher_id' => ['required', Rule::exists('users', 'id')->where(fn($query) => $query->where('role', 'teacher'))],
            'student_ids' => ['nullable', 'array'],
            'student_ids.*' => ['integer', 'exists:students,id'],
        ]);

        $group->update([
            'name' => $validated['name'],
            'schedule' => $validated['schedule'],
            'teacher_id' => $validated['teacher_id'],
        ]);
        if ($request->has('student_ids_present')) {
            $this->syncGroupStudents($course, $group, $validated['student_ids'] ?? []);
        }

        return back()->with('success', 'تم تحديث معلم المجموعة بنجاح.');
    }

    public function destroyGroup(Course $course, Group $group)
    {
        if ($group->course_id !== $course->id) {
            abort(404);
        }

        $group->delete();

        return back()->with('success', 'تم حذف المجموعة من الدورة.');
    }

    protected function syncGroupStudents(Course $course, Group $group, array $studentIds): void
    {
        $allowedStudentIds = Student::whereIn('id', $studentIds)
            ->where(function ($query) use ($course) {
                $query->whereHas('courses', fn ($courseQuery) => $courseQuery->whereKey($course->id))
                        ->orWhereHas('subscriptions', fn ($subscriptionQuery) => $subscriptionQuery->where('course_id', $course->id))
                        ->orWhereHas('groups', fn ($groupQuery) => $groupQuery->where('course_id', $course->id));
            })
            ->pluck('id');

        $group->students()->sync($allowedStudentIds);
    }
}
