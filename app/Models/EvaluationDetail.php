<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'evaluation_id',
        'criterion_id',
        'score',
    ];

    public $timestamps = false;

    // ===== RELATIONS =====

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }

    public function criterion()
    {
        return $this->belongsTo(EvaluationCriteria::class, 'criterion_id');
    }
}
