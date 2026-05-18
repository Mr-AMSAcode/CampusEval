<?php

namespace App\Models;

use App\Traits\HasPermissions;
use App\Traits\HasRoles;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/*
 * Rôles supportés:
 * - super_admin: Accès complet
 * - student: Étudiant
 * - teacher: Enseignant
 * - staff: Personnel administratif
 */
#[Fillable([
    'matricule', 'first_name', 'last_name', 'name', 'email', 'password',
    'role', 'is_active', 'phone', 'bio', 'profile_photo_path',
    'invitation_token', 'invitation_token_expires_at'
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles, HasPermissions;

    protected $dates = ['email_verified_at', 'last_login_at', 'invitation_token_expires_at'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'invitation_token_expires_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    // ===== RELATIONS =====
    
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    public function staff()
    {
        return $this->hasOne(Staff::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    // ===== HELPERS & SCOPES =====

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    public function isTeacher(): bool
    {
        return $this->role === 'teacher';
    }

    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function getFullNameAttribute(): string
    {
        return trim(sprintf('%s %s', $this->first_name ?? '', $this->last_name ?? '')) ?: $this->name;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByRole($query, string $role)
    {
        return $query->where('role', $role);
    }

    public function scopeInvitationPending($query)
    {
        return $query->whereNotNull('invitation_token')
                     ->where('password', null);
    }
}
