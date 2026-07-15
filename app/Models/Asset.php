<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use HasFactory, SoftDeletes;

    public const STATUSES = ['available', 'in_use', 'in_repair', 'retired', 'lost'];

    public const CONDITIONS = ['good', 'fair', 'for_repair', 'unserviceable'];

    public const OWNERSHIP_TYPES = ['office_owned', 'personally_owned'];

    public const CONNECTIVITY_TYPES = ['lan', 'wifi', 'both', 'none'];

    public const OS_OPTIONS = [
        'Windows 11 Pro',
        'Windows 11 Home',
        'Windows 10 Pro',
        'Windows 10 Home',
        'Windows 7',
        'Linux Mint',
        'Ubuntu',
        'macOS',
        'Other',
    ];

    public const RAM_OPTIONS = [
        '4.0/8.0 GB',
        '7.8/8.0 GB',
        '8.0/16.0 GB',
        '10.1/16.7 GB',
        '15.8/16.0 GB',
        '16.0/32.0 GB',
        '31.5/32.0 GB',
        '32.0/64.0 GB',
        '63.8/64.0 GB',
    ];

    public const STORAGE_OPTIONS = [
        '64 GB', '128 GB', '256 GB', '500 GB', '512 GB',
        '1 TB', '2 TB', '4 TB',
    ];

    protected $fillable = [
        'asset_tag', 'name', 'category_id', 'division_id',
        'serial_number', 'status',
        'purchase_date', 'purchase_cost', 'warranty_expiry',
        'specifications', 'notes',
        // Specs
        'cpu', 'ram_total', 'ram_used', 'storage_capacity', 'storage_device',
        'operating_system', 'hostname', 'utilized_by',
        'ownership_type', 'connectivity', 'wifi_network',
        'condition', 'software_installed', 'has_crowdstrike',
    ];

    protected $casts = [
        'purchase_date'    => 'date',
        'warranty_expiry'  => 'date',
        'purchase_cost'    => 'decimal:2',
        'has_crowdstrike'  => 'boolean',
    ];

    public function category(): BelongsTo   { return $this->belongsTo(Category::class); }
    public function location(): BelongsTo   { return $this->belongsTo(Location::class); }
    public function division(): BelongsTo   { return $this->belongsTo(Division::class); }
    public function assignments(): HasMany  { return $this->hasMany(Assignment::class); }
    public function maintenanceRecords(): HasMany { return $this->hasMany(MaintenanceRecord::class); }

    public function currentAssignment(): HasOne
    {
        return $this->hasOne(Assignment::class)->whereNull('returned_at')->latestOfMany('assigned_at');
    }

    public function scopeSearch($query, ?string $term)
    {
        if (! $term) return $query;
        return $query->where(function ($q) use ($term) {
            $q->where('asset_tag', 'like', "%{$term}%")
              ->orWhere('name', 'like', "%{$term}%")
              ->orWhere('serial_number', 'like', "%{$term}%")
              ->orWhere('brand', 'like', "%{$term}%")
              ->orWhere('model', 'like', "%{$term}%")
              ->orWhere('hostname', 'like', "%{$term}%")
              ->orWhere('utilized_by', 'like', "%{$term}%")
              ->orWhere('cpu', 'like', "%{$term}%");
        });
    }

    public function scopeStatus($query, ?string $status)
    {
        return $status ? $query->where('status', $status) : $query;
    }

    public static function nextAssetTag(string $prefix = 'CMP-'): string
    {
        $last = static::withTrashed()
            ->where('asset_tag', 'like', $prefix.'%')
            ->orderByRaw('LENGTH(asset_tag) desc, asset_tag desc')
            ->value('asset_tag');
        $nextNumber = 1;
        if ($last && preg_match('/(\d+)$/', $last, $matches)) {
            $nextNumber = ((int) $matches[1]) + 1;
        }
        return $prefix.str_pad((string) $nextNumber, 4, '0', STR_PAD_LEFT);
    }
}