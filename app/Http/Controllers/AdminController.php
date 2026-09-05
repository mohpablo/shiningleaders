<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Group;
use App\Models\payment;
use App\Models\Student;
use App\Models\subscription;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalParents = User::where('role', 'parent')->count();
        $totalTeachers = User::where('role', 'teacher')->count();
        $totalCourses = Course::count();
        $totalGroups = Group::count();
        $totalStudents = Student::count();

        $paidStudents = Student::whereHas('subscriptions.payments', function ($query) {
            $query->where('status', 'success');
        })->count();

        $pendingStudents = Student::whereDoesntHave('subscriptions.payments', function ($query) {
            $query->where('status', 'success');
        })->count();

        $totalEarnings = Payment::where('status', 'success')->sum('amount');
        $totalPayments = Payment::count();

        $latestGroups = Group::with('course')->latest()->limit(5)->get();

        return view('admin.dashboard', compact(
            'totalParents',
            'totalTeachers',
            'totalCourses',
            'totalGroups',
            'totalStudents',
            'paidStudents',
            'pendingStudents',
            'totalEarnings',
            'totalPayments',
            'latestGroups'
        ));
    }

    public function payments(Request $request)
    {
        $search = trim($request->string('q')->toString());
        $paymentStatus = $request->string('payment_status')->toString();

        $students = Student::where(function ($query) {
                $query->whereHas('courses')->orWhereHas('subscriptions');
            })
            ->with(['parent', 'courses', 'groups.course', 'subscriptions.course', 'subscriptions.payments'])
            ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search) {
                $query->where('students.name', 'like', "%{$search}%")
                    ->orWhereHas('parent', fn ($parentQuery) => $parentQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%"))
                    ->orWhereHas('courses', fn ($courseQuery) => $courseQuery
                        ->where('name', 'like', "%{$search}%"));
            }))
            ->when($paymentStatus === 'paid', fn ($query) => $query->whereHas('subscriptions.payments', fn ($paymentQuery) => $paymentQuery->where('status', 'success')))
            ->latest()
            ->paginate(15);

        return view('admin.payments', compact('students', 'paymentStatus'));
    }

    public function markStudentCourseAsPaid(Student $student, Course $course): RedirectResponse
    {
        abort_unless(
            $student->courses()->whereKey($course->id)->exists()
                || $student->subscriptions()->where('course_id', $course->id)->exists(),
            404
        );

        $subscription = $student->subscriptions()->firstOrCreate(
            ['course_id' => $course->id],
            [
                'parent_id' => $student->parent_id,
                'status' => 'pending',
                'valid_until' => now()->addMonth(),
                'sessions_used' => 0,
                'sessions_limit' => $course->monthly_sessions ?? 0,
            ]
        );

        $payment = $subscription->payments()->latest()->first();
        if ($payment) {
            $payment->update(['status' => 'success', 'failure_reason' => null]);
        } else {
            $subscription->payments()->create(['amount' => $course->monthly_fee, 'status' => 'success']);
        }

        $subscription->update(['status' => 'active']);

        return back()->with('success', 'تم تسجيل الدفع وتفعيل اشتراك الطالب.');
    }

    public function markStudentCourseAsUnpaid(Student $student, Course $course): RedirectResponse
    {
        abort_unless(
            $student->courses()->whereKey($course->id)->exists()
                || $student->subscriptions()->where('course_id', $course->id)->exists(),
            404
        );

        $subscription = $student->subscriptions()->firstOrCreate(
            ['course_id' => $course->id],
            [
                'parent_id' => $student->parent_id,
                'status' => 'pending',
                'valid_until' => now()->addMonth(),
                'sessions_used' => 0,
                'sessions_limit' => $course->monthly_sessions ?? 0,
            ]
        );

        $payment = $subscription->payments()->latest()->first();
        if ($payment) {
            $payment->update(['status' => 'pending', 'failure_reason' => null]);
        } else {
            $subscription->payments()->create(['amount' => $course->monthly_fee, 'status' => 'pending']);
        }

        $subscription->update(['status' => 'pending']);

        return back()->with('success', 'تم تسجيل أن الدفع لم يتم بعد.');
    }
}
