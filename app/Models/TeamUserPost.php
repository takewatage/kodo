<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamUserPost extends Model
{
    use HasFactory;
    protected $table = 'team_user_post';

    protected $fillable = [
        'id',
        'team_id',
        'post_id',
    ];
}
