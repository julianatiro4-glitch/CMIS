<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalSupport extends Model
{
    use HasFactory;

    public const STATUSES = ['in_progress', 'for_checking', 'failed', 'done'];

    protected $fillable = [
        'date',
        'division',
        'reported_by',
        'issue_problem',
        'action_taken',
        'handled_by',
        'status',
        'resolved_at',
    ];

    protected $casts = [
        'date' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    public function scopeOpenOrInProgress($query)
    {
        return $query->whereIn('status', ['in_progress', 'for_checking']);
    }
}
