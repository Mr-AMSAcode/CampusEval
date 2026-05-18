<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Nom: ClassModel (pour éviter le conflit avec le mot-clé "class")
 */
class ClassModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'classes';

    protected $fillable = [
        'name',
        'code',
        'department_id',
        'level',
        'student_count',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ===== RELATIONS =====

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(
            Teacher::class,
            'teacher_class',
            'class_id',
            'teacher_id'
        )
        ->withPivot(
            'subject',
            'hours_per_week',
            'start_date',
            'end_date',
            'status'
        )
        ->withTimestamps();
    }

    // ===== SCOPES =====

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByDepartment($query, int $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }

    public function scopeByLevel($query, string $level)
    {
        return $query->where('level', $level);
    }
}
