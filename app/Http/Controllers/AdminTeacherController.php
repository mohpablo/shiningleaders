<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminTeacherController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->string('q')->toString());

        $teachers = User::where('role', 'teacher')
            ->with('courses')
            ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            }))
            ->latest()
            ->paginate(12);

        return view('admin.programs.index', compact('teachers'));
    }

    public function create()
    {
        return view('admin.programs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'teacher_share' => ['required', 'integer', 'min:0', 'max:100'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'teacher',
            'teacher_share' => $validated['teacher_share'],
        ]);

        return redirect()->route('admin.programs.index')->with('success', 'تم إضافة المدرس بنجاح.');
    }

    public function edit(User $teacher)
    {
        if ($teacher->role !== 'teacher') {
            abort(404);
        }

        return view('admin.programs.edit', compact('teacher'));
    }

    public function update(Request $request, User $teacher)
    {
        if ($teacher->role !== 'teacher') {
            abort(404);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $teacher->id],
            'password' => ['nullable', 'string', 'min:8'],
            'teacher_share' => ['required', 'integer', 'min:0', 'max:100'],
        ]);

        $teacher->name = $validated['name'];
        $teacher->email = $validated['email'];
        $teacher->teacher_share = $validated['teacher_share'];

        if (!empty($validated['password'])) {
            $teacher->password = bcrypt($validated['password']);
        }

        $teacher->save();

        return redirect()->route('admin.programs.index')->with('success', 'تم تحديث بيانات المدرس بنجاح.');
    }

    public function destroy(User $teacher)
    {
        if ($teacher->role !== 'teacher') {
            abort(404);
        }

        $teacher->delete();

        return redirect()->route('admin.programs.index')->with('success', 'تم حذف المدرس بنجاح.');
    }
}
