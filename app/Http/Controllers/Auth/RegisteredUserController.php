<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\ClassModel;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $classes = ClassModel::where('is_active', true)
                             ->with('department')
                             ->orderBy('name')
                             ->get();

        $levels = [
            'Licence 1', 'Licence 2', 'Licence 3',
            'Master 1', 'Master 2', 'Doctorat',
        ];

        return view('auth.register', [
            'classes' => $classes,
            'levels' => $levels,
        ]);
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'matricule' => ['required', 'string', 'unique:users', 'regex:/^(GL|SR)\.[A-Z0-9]{2,10}\.[0-9]{2}\.[A-Z]$/i'],
            'level' => ['required', 'string', 'max:50'],
            'class_id' => ['required', 'exists:classes,id'],
        ], [
            'matricule.regex' => "Le matricule doit avoir le format GL.CMRY22.23.K ou SR.CMRY21.22.A",
            'level.required' => 'Le niveau est requis.',
        ]);

        $validated['matricule'] = strtoupper($validated['matricule']);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'name' => trim($validated['first_name'] . ' ' . $validated['last_name']),
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'matricule' => $validated['matricule'],
            'role' => 'student',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $class = ClassModel::findOrFail($validated['class_id']);

        Student::create([
            'user_id' => $user->id,
            'class_id' => $class->id,
            'department_id' => $class->department_id,
            'student_number' => $validated['matricule'],
            'level' => $validated['level'],
            'enrollment_date' => today(),
            'status' => 'active',
        ]);

        $class->increment('student_count');

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
