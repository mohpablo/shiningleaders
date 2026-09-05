<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParentController extends Controller
{
    public function dashboard()
    {
        $parentId = auth()->guard('web')->id();
        $children = Student::where('parent_id', $parentId)
            ->with(['subscriptions.course', 'subscriptions.payments'])
            ->get();

        $subscriptions = $children->flatMap(fn($child) => $child->subscriptions);
        $payments = $subscriptions->flatMap->payments;

        $count = $children->count();
        $totalSubscriptions = $subscriptions->count();
        $activeSubscriptions = $subscriptions->where('status', 'active')->count();
        $pendingPayments = $payments->where('status', 'pending')->count();
        $successfulPayments = $payments->where('status', 'success')->count();

        return view('parent.index', compact('children', 'count', 'totalSubscriptions', 'activeSubscriptions', 'pendingPayments', 'successfulPayments'));
    }

    public function show(Student $student)
    {
        $this->authorizeStudent($student);

        $student->load([
            'courses',
            'groups.course',
            'subscriptions.course',
            'subscriptions.payments',
            'sessionRecords' => fn ($query) => $query->with('group.course')->latest('session_number'),
        ]);
        $enrolledCourses = $student->subscriptions
            ->map(fn ($subscription) => $subscription->course)
            ->filter()
            ->unique('id')
            ->values();
        $selectedCourseIds = $student->courses->pluck('id')
            ->merge($student->groups->pluck('course_id'))
            ->merge($enrolledCourses->pluck('id'))
            ->unique()
            ->values();

        return view('parent.student', compact('student', 'enrolledCourses', 'selectedCourseIds'));
    }

    public function courses()
    {
        $courses = Course::paginate(12);
        $students = Student::where('parent_id', Auth::id())->get();

        return view('parent.courses', compact('courses', 'students'));
    }

    public function payments()
    {
        $payments = Payment::whereHas('subscription', fn($query) => $query->where('parent_id', auth()->guard('web')->id()))
            ->with(['subscription.course', 'subscription.student'])
            ->latest()
            ->paginate(12);

        return view('parent.payments', compact('payments'));
    }

    public function settings()
    {
        return view('parent.settings');
    }

    public function subscribe(Request $request, Student $student)
    {
        $this->authorizeStudent($student);

        $validated = $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
        ]);

        $course = \App\Models\Course::findOrFail($validated['course_id']);

        $subscription = $student->subscriptions()->create([
            'course_id' => $course->id,
            'parent_id' => auth()->guard('web')->id(),
            'status' => 'pending',
            'valid_until' => now()->addMonth(),
            'sessions_used' => 0,
            'sessions_limit' => $course->monthly_sessions ?? 0,
        ]);

        return redirect()->route('parent.student.subscription.checkout', [$student, $subscription]);
    }

    public function checkout(Student $student, \App\Models\Subscription $subscription)
    {
        $this->authorizeStudent($student);

        if ($subscription->student_id !== $student->id) {
            abort(403);
        }

        $payment = $subscription->payments()->where('status', 'pending')->latest()->first();

        if (!$payment) {
            $payment = $subscription->payments()->create([
                'amount' => $subscription->course->monthly_fee,
                'status' => 'pending',
            ]);
        }

        return view('parent.checkout', compact('payment', 'subscription', 'student'));
    }

    protected function authorizeStudent(Student $student)
    {
        if ($student->parent_id !== auth()->guard('web')->id()) {
            abort(403);
        }
    }

    public function create()
    {
        // Fetch courses and group them by the 'grade' column
        $coursesByGrade = Course::whereNotNull('grade')->get()->groupBy('grade');

        // Define the academic years from Pre-KG to Grade 10
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

        return view('parent.add-student', compact('coursesByGrade', 'academicYears'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'age'           => ['required', 'integer', 'min:1', 'max:30'],
            'phone_number'  => ['nullable', 'string', 'max:20'],
            'school'        => ['nullable', 'string', 'max:255'],
            'academic_year' => ['required', 'string', 'max:255'], // Now required!
            'courses'       => ['nullable', 'array'],
            'courses.*'     => ['exists:courses,id'],
        ]);

        $student = Student::create([
            'parent_id'     => auth()->guard('web')->id(),
            'name'          => $validated['name'],
            'age'           => $validated['age'],
            'phone_number'  => $validated['phone_number'],
            'school'        => $validated['school'],
            'academic_year' => $validated['academic_year'],
        ]);

        if (!empty($validated['courses'])) {
            $student->courses()->attach($validated['courses']);
        }

        return redirect()->route('parent.dashboard')->with('success', 'تم إضافة الطالب بنجاح');
    }
}
