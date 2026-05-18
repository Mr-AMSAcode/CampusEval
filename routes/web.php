<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\Auth\InvitationController;
use Illuminate\Support\Facades\Route;

// Landing page / auth home
Route::get('/', function () {

    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');

})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/invitation/{token}', [InvitationController::class, 'show'])
        ->name('invitation.show');
    Route::post('/invitation/{token}', [InvitationController::class, 'accept'])
        ->name('invitation.accept');
});

// Routes authentifiées
Route::middleware('auth', 'verified')->group(function () {
    
    // Dashboards - Router automatique selon le rôle
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===== ROUTES D'ÉVALUATION (Étudiants) =====
Route::middleware(['auth', 'verified', 'role:student'])->prefix('evaluations')->name('evaluations.')->group(function () {
    Route::get('/', [EvaluationController::class, 'index'])->name('index');
    Route::get('/create/{type}/{id}', [EvaluationController::class, 'create'])->name('create');
    Route::post('/', [EvaluationController::class, 'store'])->name('store');
    Route::get('/my-evaluations', [EvaluationController::class, 'myEvaluations'])->name('my-evaluations');
    Route::get('/{type}/{id}/statistics', [EvaluationController::class, 'showStatistics'])->name('statistics');
});

// ===== ROUTES D'ADMINISTRATION (Super Admin) =====
Route::middleware(['auth', 'verified', 'role:super_admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Gestion des utilisateurs
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('index');
        Route::get('/create', [UserManagementController::class, 'create'])->name('create');
        Route::post('/', [UserManagementController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [UserManagementController::class, 'edit'])->name('edit');
        Route::patch('/{user}', [UserManagementController::class, 'update'])->name('update');
        Route::post('/{user}/deactivate', [UserManagementController::class, 'deactivate'])->name('deactivate');
        Route::post('/{user}/activate', [UserManagementController::class, 'activate'])->name('activate');
        Route::post('/{user}/reset-password', [UserManagementController::class, 'resetPassword'])->name('reset-password');
    });
    
    // TODO: Plus de routes admin (classes, départements, modération, etc.)
});

// Routes d'authentification (Breeze)
require __DIR__.'/auth.php';
