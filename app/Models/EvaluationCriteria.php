<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationCriteria extends Model
{
    use HasFactory;

    protected $table = 'evaluation_criteria';

    protected $fillable = [
        'name',
        'description',
        'type', // 'teacher' ou 'staff'
        'weight',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ===== RELATIONS =====

    public function details()
    {
        return $this->hasMany(EvaluationDetail::class, 'criterion_id');
    }

    // ===== SCOPES =====

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForTeachers($query)
    {
        return $query->where('type', 'teacher');
    }

    public function scopeForStaff($query)
    {
        return $query->where('type', 'staff');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
