<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $user = auth()->guard('web')->user();

            if ($user->role === 'parent') {
                return redirect()->route('parent.dashboard');
            }

            if ($user->role === 'teacher') {
                return redirect()->route('teacher.dashboard');
            }

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            $fatherName = $request->registered_by === 'father' ? $request->name : $request->father_name;
            $fatherMobile = $request->registered_by === 'father' ? $request->mobile : $request->father_mobile;

            $motherName = $request->registered_by === 'mother' ? $request->name : $request->mother_name;
            $motherMobile = $request->registered_by === 'mother' ? $request->mobile : $request->mother_mobile;

            $user->parentProfile()->create([
                'registered_by' => $request->registered_by,
                'father_name' => $fatherName,
                'father_mobile' => $fatherMobile,
                'father_job' => $request->father_job ?? '',
                'mother_name' => $motherName,
                'mother_mobile' => $motherMobile,
                'mother_job' => $request->mother_job ?? '',
                'address' => $request->address,
                'ideal_community_opinion' => $request->ideal_community_opinion ?? '',
            ]);

            Auth::login($user);

            return redirect()->route('parent.dashboard');
        });
    }

    public function logout()
    {
        auth()->guard()->logout();
        return redirect('/');
    }
}
