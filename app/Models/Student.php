<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'class_id',
        'department_id',
        'student_number',
        'level',
        'enrollment_date',
        'status',
        'evaluations_count',
    ];

    protected $casts = [
        'enrollment_date' => 'date',
    ];

    // ===== RELATIONS =====

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    // ===== SCOPES =====

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByClass($query, int $classId)
    {
        return $query->where('class_id', $classId);
    }

    public function scopeByDepartment($query, int $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }

    // ===== HELPERS =====

    public function canEvaluateTeacher(Teacher $teacher): bool
    {
        // L'étudiant peut évaluer un enseignant seulement s'il/elle enseigne dans sa classe
        return $teacher->classes()
                       ->where('class_id', $this->class_id)
                       ->exists();
    }

    public function hasEvaluatedTeacher(Teacher $teacher): bool
    {
        return $this->evaluations()
                    ->where('evaluatable_type', Teacher::class)
                    ->where('evaluatable_id', $teacher->id)
                    ->exists();
    }

    public function hasEvaluatedStaff(Staff $staff): bool
    {
        return $this->evaluations()
                    ->where('evaluatable_type', Staff::class)
                    ->where('evaluatable_id', $staff->id)
                    ->exists();
    }
}
