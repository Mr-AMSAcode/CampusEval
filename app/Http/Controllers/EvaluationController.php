<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\EvaluationCriteria;
use App\Models\EvaluationDetail;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * EvaluationController - Gestion des évaluations
 * Sécurité critique: Application stricte de l'anonymité
 */
class EvaluationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    /**
     * Afficher la liste des enseignants et du personnel évaluables
     */
    public function index(): View
    {
        $user = auth()->user();

        // Seuls les étudiants peuvent évaluer
        if (!$user->isStudent()) {
            abort(403, 'Seuls les étudiants peuvent créer des évaluations.');
        }

        $student = $user->student;
        if (!$student) {
            abort(403, 'Profil étudiant non trouvé.');
        }

        // Récupérer les enseignants qui enseignent cette classe
        $teachers = Teacher::query()
            ->whereHas('classes', function ($query) use ($student) {
                $query->where('class_id', $student->class_id);
            })
            ->where('status', 'active')
            ->withCount('evaluations')
            ->get();

        // Récupérer tout le personnel administratif
        $staff = Staff::where('status', 'active')
            ->withCount('evaluations')
            ->get();

        // Récupérer les évaluations déjà faites par cet étudiant
        $evaluatedTeacherIds = $student->evaluations()
            ->where('evaluatable_type', Teacher::class)
            ->distinct()
            ->pluck('evaluatable_id')
            ->toArray();

        $evaluatedStaffIds = $student->evaluations()
            ->where('evaluatable_type', Staff::class)
            ->distinct()
            ->pluck('evaluatable_id')
            ->toArray();

        return view('evaluations.index', [
            'teachers' => $teachers,
            'staff' => $staff,
            'evaluatedTeacherIds' => $evaluatedTeacherIds,
            'evaluatedStaffIds' => $evaluatedStaffIds,
        ]);
    }

    /**
     * Afficher le formulaire de création d'évaluation
     */
    public function create(string $type, int $id): View
    {
        $user = auth()->user();

        // Seuls les étudiants peuvent évaluer
        if (!$user->isStudent()) {
            abort(403);
        }

        $student = $user->student;
        if (!$student) {
            abort(403);
        }

        if ($type === 'teacher') {
            $evaluatable = Teacher::findOrFail($id);

            // Vérifier que l'étudiant peut évaluer cet enseignant
            if (!$student->canEvaluateTeacher($evaluatable)) {
                abort(403, "Vous ne pouvez pas évaluer cet enseignant.");
            }

            // Vérifier qu'aucune évaluation n'existe déjà
            if ($student->hasEvaluatedTeacher($evaluatable)) {
                abort(403, "Vous avez déjà évalué cet enseignant.");
            }
        } elseif ($type === 'staff') {
            $evaluatable = Staff::findOrFail($id);

            // Les étudiants peuvent évaluer tous les personnels
            if ($student->hasEvaluatedStaff($evaluatable)) {
                abort(403, "Vous avez déjà évalué ce personnel.");
            }
        } else {
            abort(400);
        }

        // Récupérer les critères d'évaluation
        $criteria = EvaluationCriteria::where('type', $type)
                                      ->where('is_active', true)
                                      ->orderBy('order')
                                      ->get();

        return view('evaluations.create', [
            'type' => $type,
            'evaluatable' => $evaluatable,
            'criteria' => $criteria,
        ]);
    }

    /**
     * Stocker une nouvelle évaluation
     */
    public function store(Request $request): RedirectResponse
    {
        $user = auth()->user();

        if (!$user->isStudent()) {
            abort(403);
        }

        $student = $user->student;
        if (!$student) {
            abort(403);
        }

        $validated = $request->validate([
            'type' => ['required', 'in:teacher,staff'],
            'evaluatable_id' => ['required', 'integer'],
            'rating' => ['required', 'numeric', 'between:1,5'],
            'comment' => ['nullable', 'string', 'max:1000'],
            'is_anonymous' => ['boolean'],
            'criteria_scores' => ['required', 'array'],
            'criteria_scores.*' => ['required', 'integer', 'between:1,5'],
        ]);

        // Déterminer le type de modèle
        if ($validated['type'] === 'teacher') {
            $evaluatable = Teacher::findOrFail($validated['evaluatable_id']);

            if (!$student->canEvaluateTeacher($evaluatable)) {
                abort(403);
            }

            if ($student->hasEvaluatedTeacher($evaluatable)) {
                abort(403, "Vous avez déjà évalué cet enseignant.");
            }

            $evaluatable_type = Teacher::class;
        } else {
            $evaluatable = Staff::findOrFail($validated['evaluatable_id']);

            if ($student->hasEvaluatedStaff($evaluatable)) {
                abort(403, "Vous avez déjà évalué ce personnel.");
            }

            $evaluatable_type = Staff::class;
        }

        // Créer l'évaluation
        $evaluation = Evaluation::create([
            'student_id' => $student->id,
            'evaluatable_type' => $evaluatable_type,
            'evaluatable_id' => $validated['evaluatable_id'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_anonymous' => $validated['is_anonymous'] ?? true,
            'status' => 'pending', // À modérer avant publication
            'shows_student_identity' => false,
        ]);

        // Créer les détails des critères
        foreach ($validated['criteria_scores'] as $criterionId => $score) {
            EvaluationDetail::create([
                'evaluation_id' => $evaluation->id,
                'criterion_id' => $criterionId,
                'score' => $score,
            ]);
        }

        // Anonymiser l'évaluation
        $evaluation->hideStudentIdentity();

        // Incrémenter le compteur d'évaluations de l'étudiant
        $student->increment('evaluations_count');

        return redirect()->route('evaluations.index')
                       ->with('success', 'Évaluation soumise avec succès. Elle sera visible après modération.');
    }

    /**
     * Afficher les statistiques d'un enseignant/personnel
     */
    public function showStatistics(string $type, int $id): View
    {
        $user = auth()->user();

        // Récupérer l'évalué
        if ($type === 'teacher') {
            $evaluatable = Teacher::findOrFail($id);

            // Vérifier les permissions
            $this->authorize('viewStatistics', $evaluatable);
        } elseif ($type === 'staff') {
            $evaluatable = Staff::findOrFail($id);

            // Vérifier les permissions
            $this->authorize('viewStatistics', $evaluatable);
        } else {
            abort(400);
        }

        // Récupérer les évaluations publiées
        $evaluations = $evaluatable->evaluations()
                                  ->where('status', 'published')
                                  ->get();

        $stats = [
            'total' => $evaluations->count(),
            'average' => $evaluations->avg('rating') ?? 0,
            'avg_rounded' => number_format($evaluations->avg('rating') ?? 0, 1),
        ];

        return view('evaluations.statistics', [
            'type' => $type,
            'evaluatable' => $evaluatable,
            'statistics' => $stats,
            'evaluations' => $evaluations,
        ]);
    }

    /**
     * Voir l'historique des évaluations soumises (pour étudiants)
     */
    public function myEvaluations(): View
    {
        $user = auth()->user();

        if (!$user->isStudent()) {
            abort(403);
        }

        $student = $user->student;
        $evaluations = $student->evaluations()
                              ->with('evaluatable')
                              ->latest()
                              ->get();

        return view('evaluations.my-evaluations', [
            'evaluations' => $evaluations,
        ]);
    }
}
