<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'old_values' => 'json',
        'new_values' => 'json',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    // ===== RELATIONS =====

    public function user()
    {
        return $this->belongsTo(User::class)->nullable();
    }

    // ===== SCOPES =====

    public function scopeByAction($query, string $action)
    {
        return $query->where('action', $action);
    }

    public function scopeByModel($query, string $modelType)
    {
        return $query->where('model_type', $modelType);
    }

    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }
}
