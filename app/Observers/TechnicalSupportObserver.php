<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\TechnicalSupport;

class TechnicalSupportObserver
{
    public function created(TechnicalSupport $record): void
    {
        $label = "Technical Support #{$record->id}";

        ActivityLog::record(
            action: 'created',
            model: $record,
            label: $label,
            new: $this->getValues($record),
        );
    }

    public function updated(TechnicalSupport $record): void
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

        $label = "Technical Support #{$record->id}";

        ActivityLog::record(
            action: 'updated',
            model: $record,
            label: $label,
            old: $old,
            new: $new,
        );
    }

    public function deleted(TechnicalSupport $record): void
    {
        $label = "Technical Support #{$record->id}";

        ActivityLog::record(
            action: 'deleted',
            model: $record,
            label: $label,
            old: $this->getValues($record),
        );
    }

    private function getValues(TechnicalSupport $record): array
    {
        return collect($record->toArray())
            ->except(ActivityLog::$excludedFields)
            ->toArray();
    }
}
