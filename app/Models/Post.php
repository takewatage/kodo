<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'group_id',
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

}
