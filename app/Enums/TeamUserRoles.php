<?php

namespace App\Enums;

enum TeamUserRoles: string
{
    case Admin = 'admin'; // 管理者
    case General = 'general'; // 一般

    public function getLabel(): string
    {
        return match ($this) {
            self::Admin => '管理者',
            self::General => '一般',
        };
    }
}
