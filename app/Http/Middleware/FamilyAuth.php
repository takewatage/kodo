<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FamilyAuth
{
    public function handle(Request $request, Closure $next, ?string $role = null): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // 家族に所属していない場合
        if (!$user->family_id) {
            return redirect()->route('dashboard')->with('error', '家族に所属していません。');
        }

        // 特定の役割が必要な場合
        if ($role) {
            $allowedRoles = explode('|', $role);

            if (!in_array($user->family_role, $allowedRoles)) {
                abort(403, '権限がありません。');
            }
        }

        return $next($request);
    }
}
