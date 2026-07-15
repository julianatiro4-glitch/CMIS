<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\Asset;

class AssetObserver
{
    public function created(Asset $asset): void
    {
        ActivityLog::record(
            action: 'created',
            model: $asset,
            label: $asset->asset_tag,
            new: $this->getValues($asset),
        );
    }

    public function updated(Asset $asset): void
    {
        $changed = collect($asset->getDirty())
            ->except(ActivityLog::$excludedFields)
            ->keys()
            ->toArray();

        if (empty($changed)) {
            return;
        }

        $old = collect($asset->getOriginal())
            ->only($changed)
            ->toArray();

        $new = collect($asset->getDirty())
            ->only($changed)
            ->toArray();

        ActivityLog::record(
            action: 'updated',
            model: $asset,
            label: $asset->asset_tag,
            old: $old,
            new: $new,
        );
    }

    public function deleted(Asset $asset): void
    {
        ActivityLog::record(
            action: 'deleted',
            model: $asset,
            label: $asset->asset_tag,
            old: $this->getValues($asset),
        );
    }

    public function restored(Asset $asset): void
    {
        ActivityLog::record(
            action: 'restored',
            model: $asset,
            label: $asset->asset_tag,
            new: $this->getValues($asset),
        );
    }

    private function getValues(Asset $asset): array
    {
        return collect($asset->getAttributes())
            ->except(ActivityLog::$excludedFields)
            ->toArray();
    }
}
