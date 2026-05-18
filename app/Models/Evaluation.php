<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Evaluation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'evaluatable_type',
        'evaluatable_id',
        'rating',
        'comment',
        'is_anonymous',
        'anonymized_hash',
        'anonymous_until',
        'status',
        'shows_student_identity',
        'reviewed_at',
        'reviewed_by_id',
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'shows_student_identity' => 'boolean',
        'rating' => 'float',
        'anonymous_until' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    // ===== RELATIONS =====

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function evaluatable()
    {
        return $this->morphTo();
    }

    public function details()
    {
        return $this->hasMany(EvaluationDetail::class);
    }

    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by_id')->nullable();
    }

    // ===== SCOPES =====

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeForTeacher($query, Teacher $teacher)
    {
        return $query->where('evaluatable_type', Teacher::class)
                     ->where('evaluatable_id', $teacher->id);
    }

    public function scopeForStaff($query, Staff $staff)
    {
        return $query->where('evaluatable_type', Staff::class)
                     ->where('evaluatable_id', $staff->id);
    }

    public function scopeAnonymous($query)
    {
        return $query->where('is_anonymous', true)
                     ->where('shows_student_identity', false);
    }

    public function scopeByStudent($query, int $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    // ===== HELPERS =====

    public function generateAnonymousHash(): string
    {
        return (string) Str::uuid();
    }

    public function hideStudentIdentity(): self
    {
        $this->update([
            'shows_student_identity' => false,
            'anonymized_hash' => $this->generateAnonymousHash(),
        ]);

        return $this;
    }

    public function isReviewed(): bool
    {
        return $this->reviewed_at !== null;
    }
}
