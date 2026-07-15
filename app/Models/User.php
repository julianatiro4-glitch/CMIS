<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_IT_STAFF = 'it_staff';
    public const ROLE_VIEWER = 'viewer';
    public const ROLES = [self::ROLE_ADMIN, self::ROLE_IT_STAFF, self::ROLE_VIEWER];

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isItStaff(): bool
    {
        return $this->role === self::ROLE_IT_STAFF;
    }

    public function isViewer(): bool
    {
        return $this->role === self::ROLE_VIEWER;
    }

    public function canManage(): bool
    {
        return $this->isAdmin() || $this->isItStaff();
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }
}