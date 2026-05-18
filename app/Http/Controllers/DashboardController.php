<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

/**
 * DashboardController - Routage vers les dashboards appropriés selon le rôle
 */
class DashboardController extends Controller
{


    /**
     * Afficher le dashboard approprié selon le rôle
     */
    public function index(): View
    {
        $user = auth()->user();

        // Router vers le bon dashboard
        if ($user->isSuperAdmin()) {
            return $this->adminDashboard();
        } elseif ($user->isStudent()) {
            return $this->studentDashboard();
        } elseif ($user->isTeacher()) {
            return $this->teacherDashboard();
        } elseif ($user->isStaff()) {
            return $this->staffDashboard();
        }

        abort(403, 'Rôle non reconnu.');
    }

    /**
     * Dashboard Super Admin
     */
    private function adminDashboard(): View
    {
        $stats = [
            'total_users' => \App\Models\User::count(),
            'total_students' => \App\Models\Student::count(),
            'total_teachers' => \App\Models\Teacher::count(),
            'total_staff' => \App\Models\Staff::count(),
            'total_evaluations' => \App\Models\Evaluation::where('status', 'published')->count(),
            'pending_evaluations' => \App\Models\Evaluation::where('status', 'pending')->count(),
            'average_rating' => round(\App\Models\Evaluation::where('status', 'published')->avg('rating') ?? 0, 2),
        ];

        $recent_evaluations = \App\Models\Evaluation::where('status', 'published')
                                                   ->latest()
                                                   ->limit(10)
                                                   ->get();

        $top_teachers = \App\Models\Teacher::where('total_evaluations', '>', 0)
                                           ->orderBy('average_rating', 'desc')
                                           ->limit(5)
                                           ->get();

        return view('dashboards.admin', [
            'stats' => $stats,
            'recent_evaluations' => $recent_evaluations,
            'top_teachers' => $top_teachers,
        ]);
    }

    /**
     * Dashboard Étudiant
     */
    private function studentDashboard(): View
    {
        $user = auth()->user();
        $student = $user->student;

        if (!$student) {
            abort(403);
        }

        $evaluated_teachers = $student->evaluations()
                                     ->where('evaluatable_type', \App\Models\Teacher::class)
                                     ->count();

        $evaluated_staff = $student->evaluations()
                                 ->where('evaluatable_type', \App\Models\Staff::class)
                                 ->count();

        $available_teachers = \App\Models\Teacher::query()
            ->whereHas('classes', function ($query) use ($student) {
                $query->where('class_id', $student->class_id);
            })
            ->where('status', 'active')
            ->count();

        $available_staff = \App\Models\Staff::where('status', 'active')->count();

        return view('dashboards.student', [
            'student' => $student,
            'evaluated_teachers' => $evaluated_teachers,
            'evaluated_staff' => $evaluated_staff,
            'available_teachers' => $available_teachers,
            'available_staff' => $available_staff,
        ]);
    }

    /**
     * Dashboard Enseignant
     */
    private function teacherDashboard(): View
    {
        $user = auth()->user();
        $teacher = $user->teacher;

        if (!$teacher) {
            abort(403);
        }

        $stats = [
            'total_evaluations' => $teacher->total_evaluations,
            'average_rating' => round($teacher->average_rating, 2),
            'recent_evaluations' => $teacher->evaluations()
                                           ->where('status', 'published')
                                           ->latest()
                                           ->limit(5)
                                           ->get(),
        ];

        $classes = $teacher->classes()->orderBy('name')->get();

        return view('dashboards.teacher', [
            'teacher' => $teacher,
            'stats' => $stats,
            'classes' => $classes,
        ]);
    }

    /**
     * Dashboard Personnel Administratif
     */
    private function staffDashboard(): View
    {
        $user = auth()->user();
        $staff = $user->staff;

        if (!$staff) {
            abort(403);
        }

        $stats = [
            'total_evaluations' => $staff->total_evaluations,
            'average_rating' => round($staff->average_rating, 2),
            'recent_evaluations' => $staff->evaluations()
                                        ->where('status', 'published')
                                        ->latest()
                                        ->limit(5)
                                        ->get(),
        ];

        return view('dashboards.staff', [
            'staff' => $staff,
            'stats' => $stats,
        ]);
    }
}
