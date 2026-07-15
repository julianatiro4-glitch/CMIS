<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\MaintenanceRecord;

class MaintenanceRecordObserver
{
    public function created(MaintenanceRecord $record): void
    {
        $record->loadMissing('asset');
        $label = ($record->asset?->asset_tag ?? $record->asset_id) . ': ' . substr($record->issue_description, 0, 50);

        ActivityLog::record(
            action: 'created',
            model: $record,
            label: $label,
            new: $this->getValues($record),
        );
    }

    public function updated(MaintenanceRecord $record): void
    {
        $changed = collect($record->getDirty())
            ->except(ActivityLog::$excludedFields)
            ->keys()
            ->toArray();

        if (empty($changed)) {
            return;
        }

        $old = collect($record->getOriginal())
            ->only($changed)
            ->toArray();

        $new = collect($record->getDirty())
            ->only($changed)
            ->toArray();

        $record->loadMissing('asset');
        $label = ($record->asset?->asset_tag ?? $record->asset_id) . ': ' . substr($record->issue_description, 0, 50);

        ActivityLog::record(
            action: 'updated',
            model: $record,
            label: $label,
            old: $old,
            new: $new,
        );
    }

    public function deleted(MaintenanceRecord $record): void
    {
        $record->loadMissing('asset');
        $label = ($record->asset?->asset_tag ?? $record->asset_id) . ': ' . substr($record->issue_description, 0, 50);

        ActivityLog::record(
            action: 'deleted',
            model: $record,
            label: $label,
            old: $this->getValues($record),
        );
    }

    private function getValues(MaintenanceRecord $record): array
    {
        return collect($record->getAttributes())
            ->except(ActivityLog::$excludedFields)
            ->toArray();
    }
}
