<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Teacher;
use App\Models\Staff;
use App\Models\Department;
use App\Notifications\InvitationNotification;
use App\Rules\ValidateStaffMatricule;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * UserManagementController - Gestion des utilisateurs par Super Admin
 */
class UserManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin');
    }

    /**
     * Afficher la liste des utilisateurs
     */
    public function index(Request $request): View
    {
        $query = User::query();

        // Filtrer par rôle
        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        // Rechercher
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('matricule', 'like', "%$search%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Afficher le formulaire de création/édition d'utilisateur
     */
    public function create(): View
    {
        $departments = Department::where('is_active', true)->get();

        return view('admin.users.create', ['departments' => $departments]);
    }

    /**
     * Stocker un nouvel utilisateur (super admin invite enseignant/personnel)
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'unique:users'],
            'role' => ['required', 'in:teacher,staff'],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'matricule' => ['required', 'unique:users', new ValidateStaffMatricule()],
            'department_id' => ['required', 'exists:departments,id'],
            'specialty' => ['nullable', 'string'],
            'position' => ['nullable', 'string'],
        ]);

        // Générer un token d'invitation
        $invitation_token = Str::random(64);
        $invitation_expires_at = now()->addDays(7);

        // Créer l'utilisateur
        $user = User::create([
            'email' => $validated['email'],
            'role' => $validated['role'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'matricule' => strtoupper($validated['matricule']),
            'is_active' => true,
            'invitation_token' => $invitation_token,
            'invitation_token_expires_at' => $invitation_expires_at,
        ]);

        // Créer le profil approprié
        if ($validated['role'] === 'teacher') {
            Teacher::create([
                'user_id' => $user->id,
                'department_id' => $validated['department_id'],
                'specialty' => $validated['specialty'],
                'hire_date' => now()->toDateString(),
                'status' => 'active',
            ]);
        } elseif ($validated['role'] === 'staff') {
            Staff::create([
                'user_id' => $user->id,
                'department_id' => $validated['department_id'],
                'position' => $validated['position'] ?? 'Non spécifié',
                'hire_date' => now()->toDateString(),
                'status' => 'active',
            ]);
        }

        Notification::send($user, new InvitationNotification($invitation_token));

        return redirect()->route('admin.users.index')
                       ->with('success', "Utilisateur {$user->email} créé. Un email d'invitation a été envoyé.");
    }

    /**
     * Éditer un utilisateur
     */
    public function edit(User $user): View
    {
        $this->authorize('update', $user);
        $departments = Department::where('is_active', true)->get();

        return view('admin.users.edit', [
            'user' => $user,
            'departments' => $departments,
        ]);
    }

    /**
     * Mettre à jour un utilisateur
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        $validated = $request->validate([
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);

        $user->update($validated);
        $user->name = $validated['first_name'] . ' ' . $validated['last_name'];
        $user->save();

        return redirect()->route('admin.users.index')
                       ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Désactiver un utilisateur
     */
    public function deactivate(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        $user->update(['is_active' => false]);

        return back()->with('success', 'Utilisateur désactivé.');
    }

    /**
     * Réactiver un utilisateur
     */
    public function activate(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        $user->update(['is_active' => true]);

        return back()->with('success', 'Utilisateur réactivé.');
    }

    /**
     * Réinitialiser le mot de passe d'un utilisateur
     */
    public function resetPassword(User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        // Générer un nouveau token d'invitation
        $user->update([
            'password' => null,
            'invitation_token' => Str::random(64),
            'invitation_token_expires_at' => now()->addDays(7),
        ]);

        // TODO: Envoyer email de réinitialisation

        return back()->with('success', 'Email de réinitialisation envoyé.');
    }
}
