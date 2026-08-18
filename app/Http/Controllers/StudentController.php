<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        // استدعاء الطلاب مع العلاقات (الكورسات وولي الأمر) لتجنب مشكلة N+1 Query
        // وعرض 15 طالب في كل صفحة (Pagination)
        $students = Student::with(['courses', 'parent'])
            ->latest()
            ->paginate(15);

        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        $academicYears = [
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

        return view('parent.add-student', compact('academicYears'));
    }

    // Save Step 1 & Redirect to Step 2
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'age'           => ['required', 'integer', 'min:1', 'max:30'],
            'phone_number'  => ['required', 'string', 'max:20'],
            'school'        => ['required', 'string', 'max:255'],
            'academic_year' => ['required', 'string', 'max:255'],
        ]);

        $student = Student::create([
            'parent_id'     => auth()->guard('web')->id(),
            'name'          => $validated['name'],
            'age'           => $validated['age'],
            'phone_number'  => $validated['phone_number'],
            'school'        => $validated['school'],
            'academic_year' => $validated['academic_year'],
        ]);

        // Redirect directly to the courses page for this student
        return redirect()->route('select-courses', $student->id);
    }

    // Step 2 Form: Pure PHP filtered courses by student grade
    public function selectCourses(Student $student)
    {
        abort_if($student->parent_id !== auth()->guard('web')->id(), 403);

        // Fetch ONLY courses matching student's grade via PHP
        $courses = Course::where('grade', $student->academic_year)->get();

        return view('parent.select-courses', compact('student', 'courses'));
    }

    // Save Step 2
    public function storeCourses(Request $request, Student $student)
    {
        abort_if($student->parent_id !== auth()->guard('web')->id(), 403);

        $validated = $request->validate([
            'courses'   => ['nullable', 'array'],
            'courses.*' => ['exists:courses,id'],
        ]);

        if (!empty($validated['courses'])) {
            $student->courses()->sync($validated['courses']);
        }

        return redirect()->route('parent.dashboard')->with('success', 'تم إضافة الطالب وتحديد الكورسات بنجاح');
    }
}
