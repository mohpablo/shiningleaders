<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Group;
use App\Models\payment;
use App\Models\Student;
use App\Models\subscription;
use App\Models\User;

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

        $totalEarnings = payment::where('status', 'success')->sum('amount');
        $totalPayments = payment::count();

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
}
