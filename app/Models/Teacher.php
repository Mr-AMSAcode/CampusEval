<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'department_id',
        'specialty',
        'qualifications',
        'hire_date',
        'status',
        'total_evaluations',
        'average_rating',
    ];

    protected $casts = [
        'hire_date' => 'date',
        'average_rating' => 'float',
    ];

    // ===== RELATIONS =====

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function classes()
    {
        return $this->belongsToMany(
            ClassModel::class,
            'teacher_class',
            'teacher_id',
            'class_id'
        )->withPivot([
            'subject',
            'hours_per_week',
            'start_date',
            'end_date',
            'status'
        ])->withTimestamps();
    }

    public function evaluations()
    {
        return $this->morphMany(Evaluation::class, 'evaluatable');
    }

    // ===== SCOPES =====

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByDepartment($query, int $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }

    public function scopeWithHighestRating($query)
    {
        return $query->orderBy('average_rating', 'desc');
    }

    // ===== HELPERS =====

    public function getPublishedEvaluationsAttribute()
    {
        return $this->evaluations()
                    ->where('status', 'published')
                    ->count();
    }

    public function updateAverageRating(): void
    {
        $avg = $this->evaluations()
                    ->where('status', 'published')
                    ->avg('rating') ?? 0;
        
        $this->update([
            'average_rating' => round($avg, 2),
            'total_evaluations' => $this->evaluations()
                                       ->where('status', 'published')
                                       ->count(),
        ]);
    }
}
