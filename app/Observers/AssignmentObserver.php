<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\Assignment;

class AssignmentObserver
{
    public function created(Assignment $assignment): void
    {
        $assignment->loadMissing(['asset', 'user']);
        $label = ($assignment->asset?->asset_tag ?? $assignment->asset_id) . ' to ' . ($assignment->user?->name ?? $assignment->user_id);
        
        ActivityLog::record(
            action: 'created',
            model: $assignment,
            label: $label,
            new: $this->getValues($assignment),
        );
    }

    public function updated(Assignment $assignment): void
    {
        $changed = collect($assignment->getDirty())
            ->except(ActivityLog::$excludedFields)
            ->keys()
            ->toArray();

        if (empty($changed)) {
            return;
        }

        $old = collect($assignment->getOriginal())
            ->only($changed)
            ->toArray();

        $new = collect($assignment->getDirty())
            ->only($changed)
            ->toArray();

        $assignment->loadMissing(['asset', 'user']);
        $label = ($assignment->asset?->asset_tag ?? $assignment->asset_id) . ' to ' . ($assignment->user?->name ?? $assignment->user_id);

        ActivityLog::record(
            action: 'updated',
            model: $assignment,
            label: $label,
            old: $old,
            new: $new,
        );
    }

    public function deleted(Assignment $assignment): void
    {
        $assignment->loadMissing(['asset', 'user']);
        $label = ($assignment->asset?->asset_tag ?? $assignment->asset_id) . ' to ' . ($assignment->user?->name ?? $assignment->user_id);

        ActivityLog::record(
            action: 'deleted',
            model: $assignment,
            label: $label,
            old: $this->getValues($assignment),
        );
    }

    private function getValues(Assignment $assignment): array
    {
        return collect($assignment->getAttributes())
            ->except(ActivityLog::$excludedFields)
            ->toArray();
    }
}
