<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminParentController extends Controller
{
    public function index()
    {
        $parents = User::where('role', 'parent')
            ->with(['students.subscriptions.course'])
            ->latest()
            ->paginate(12);

        return view('admin.parents.index', compact('parents'));
    }

    public function show(User $parent)
    {
        if ($parent->role !== 'parent') {
            abort(404);
        }

        $parent->load(['students.subscriptions.course']);

        return view('admin.parents.show', compact('parent'));
    }

    public function destroy(User $parent)
    {
        if ($parent->role !== 'parent') {
            abort(404);
        }

        $parent->delete();

        return redirect()->route('admin.parents.index')->with('success', 'تم حذف ولي الأمر وجميع طلابه المرتبطين بنجاح.');
    }
}
