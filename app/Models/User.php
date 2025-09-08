<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @method static where(string $string, string $email)
 * @property mixed $id
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'urlName',
        'email',
        'password',
        'role',
        'introduction',
        'last_login_group_id',
        'family_id',
        'family_role',
        'joined_family_at',
        'family_permissions',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'family_permissions' => 'array',
        'joined_family_at' => 'datetime',
    ];

    /**
     * @return BelongsTo
     */
    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    public function ownedFamily(): HasMany
    {
        return $this->hasMany(Family::class, 'owner_id');
    }

    /**
     * @return bool
     */
    public function isOwnerOfFamily(): bool
    {
        return $this->family() && $this->family()->owner_id === $this->id;
    }

    public function isFamilyMember(): bool
    {
        return $this->family_id !== null;
    }

    public function canManageFamily(): bool
    {
        return in_array($this->family_role, ['owner', 'parent']);
    }
}
