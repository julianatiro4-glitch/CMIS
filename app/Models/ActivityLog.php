<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'model_label',
        'description',
        'old_values',
        'new_values',
        'ip_address',
        'created_at',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'created_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Fields to exclude from change tracking (too noisy or irrelevant)
    public static array $excludedFields = [
        'updated_at', 'created_at', 'deleted_at',
    ];

    /**
     * Helper to log an action anywhere in the app.
     */
    public static function record(
        string $action,
        Model $model,
        string $label,
        ?array $old = null,
        ?array $new = null,
    ): void {
        static::create([
            'user_id'     => auth()->id(),
            'action'      => $action,
            'model_type'  => get_class($model),
            'model_id'    => $model->getKey(),
            'model_label' => $label,
            'description' => ucfirst($action).' '.class_basename($model).': '.$label,
            'old_values'  => $old,
            'new_values'  => $new,
            'ip_address'  => request()->ip(),
            'created_at'  => now(),
        ]);
    }
}
