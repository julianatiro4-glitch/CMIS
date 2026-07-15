<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'building',
        'floor',
        'room',
        'notes',
    ];

    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class);
    }

    public function divisions(): HasMany
    {
        return $this->hasMany(Division::class);
    }

    public function getFullNameAttribute(): string
    {
        return trim(collect([$this->name, $this->building, $this->floor, $this->room])
            ->filter()
            ->implode(' - '));
    }
}