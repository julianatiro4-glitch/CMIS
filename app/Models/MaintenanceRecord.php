<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceRecord extends Model
{
    use HasFactory;

    public const STATUSES = ['open', 'in_progress', 'resolved'];

    protected $fillable = [
        'asset_id',
        'reported_by',
        'technician',
        'issue_description',
        'status',
        'cost',
        'resolution_notes',
        'opened_at',
        'resolved_at',
    ];

    protected $casts = [
        'opened_at' => 'datetime',
        'resolved_at' => 'datetime',
        'cost' => 'decimal:2',
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function reportedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function scopeOpenOrInProgress($query)
    {
        return $query->whereIn('status', ['open', 'in_progress']);
    }
}