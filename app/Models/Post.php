<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;

class Post extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'view_auth_type',
    ];

    public const VIEW_AUTH_TYPE_PUBLIC = 0;
    public const VIEW_AUTH_TYPE_GROUP = 1;
    public const VIEW_AUTH_TYPE_PRIVATE = 2;
    public const VIEW_AUTH_TYPE_LIST = [
        self::VIEW_AUTH_TYPE_PUBLIC => 'パブリック',
        self::VIEW_AUTH_TYPE_GROUP => 'グループのみ',
        self::VIEW_AUTH_TYPE_PRIVATE => 'プライベート',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function teamUsers(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_user_post');
    }


    public function scopeHomeFilter (Builder $query, Request $request): void {
        $query->where('');
    }
}
