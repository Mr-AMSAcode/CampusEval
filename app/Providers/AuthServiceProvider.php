<?php

namespace App\Providers;

use App\Models\ClassModel;
use App\Models\Department;
use App\Models\Evaluation;
use App\Models\Staff;
use App\Models\Teacher;
use App\Models\User;
use App\Policies\ClassPolicy;
use App\Policies\DepartmentPolicy;
use App\Policies\EvaluationPolicy;
use App\Policies\StaffPolicy;
use App\Policies\TeacherPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Modèles et leurs policies
        User::class => UserPolicy::class,
        Teacher::class => TeacherPolicy::class,
        Staff::class => StaffPolicy::class,
        Department::class => DepartmentPolicy::class,
        ClassModel::class => ClassPolicy::class,
        Evaluation::class => EvaluationPolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // ===== GATES (Portes d'accès) =====

        // Vérifier si l'utilisateur est super admin
        Gate::define('is-super-admin', function (User $user) {
            return $user->isSuperAdmin();
        });

        // Vérifier si l'utilisateur peut gérer les utilisateurs
        Gate::define('manage-users', function (User $user) {
            return $user->canManageUsers();
        });

        // Vérifier si l'utilisateur peut voir les données sensibles
        Gate::define('view-sensitive-data', function (User $user) {
            return $user->canViewSensitiveData();
        });

        // Vérifier si l'utilisateur peut gérer les classes
        Gate::define('manage-classes', function (User $user) {
            return $user->canManageClasses();
        });

        // Vérifier si l'utilisateur peut gérer les départements
        Gate::define('manage-departments', function (User $user) {
            return $user->canManageDepartments();
        });

        // Vérifier si l'utilisateur peut modérer les évaluations
        Gate::define('moderate-evaluations', function (User $user) {
            return $user->canModerateEvaluations();
        });

        // Vérifier si l'utilisateur peut exporter les données
        Gate::define('export-data', function (User $user) {
            return $user->canExportData();
        });

        // Vérifier si l'utilisateur peut voir les statistiques globales
        Gate::define('view-global-statistics', function (User $user) {
            return $user->canViewGlobalStatistics();
        });
    }
}
