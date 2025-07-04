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
    protected $fillable = ['user_id', 'title', 'content', 'view_auth_type'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function teamUsers(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_user_post');
    }

    public function scopeFilter($query, array $filters): void
    {
        $query
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                });
            })
            ->when($filters['role'] ?? null, function ($query, $role) {
                $query->whereRole($role);
            })
            ->when($filters['trashed'] ?? null, function ($query, $trashed) {
                if ($trashed === 'with') {
                    $query->withTrashed();
                } elseif ($trashed === 'only') {
                    $query->onlyTrashed();
                }
            });
    }
}
