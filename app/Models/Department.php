<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'description',
        'head_name',
        'contact_email',
        'phone',
        'student_count',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ===== RELATIONS =====

    public function classes()
    {
        return $this->hasMany(ClassModel::class);
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    public function staff()
    {
        return $this->hasMany(Staff::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    // ===== SCOPES =====

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
