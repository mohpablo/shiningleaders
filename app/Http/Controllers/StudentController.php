<?php

namespace App\Http\Controllers;

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
}
