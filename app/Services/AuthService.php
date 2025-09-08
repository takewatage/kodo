<?php

namespace App\Services;

use App\Models\Family;
use App\Models\User;
use App\Repositories\Contracts\UserFamilyRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthService
{
    public function __construct(private UserFamilyRepositoryInterface $userFamilyRepository)
    {
    }

    /**
     * 通常のユーザーログイン
     */
    public function login(array $credentials, bool $remember = false): bool
    {
        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // 家族に所属している場合はセッション情報を設定
            if ($user->family_id) {
                $family = $this->userFamilyRepository->getUserFamily($user);
                if ($family) {
                    Session::put('family_id', $family->id);
                    Session::put('family_name', $family->name);
                    Session::put('family_role', $user->family_role);
                }
            }

            Session::regenerate();
            return true;
        }

        return false;
    }

    /**
     * 家族コードを使用したログイン
     */
    public function loginWithFamilyCode(string $familyCode, array $credentials, bool $remember = false): ?User
    {
        // 家族コードで家族を検索
        $family = $this->familyAuthService->authenticateByFamilyCode($familyCode);

        if (!$family) {
            return null;
        }

        // 家族メンバーとしてログイン
        return $this->familyAuthService->loginAsFamilyMember(
            $family,
            $credentials['email'] ?? '',
            $credentials['password'] ?? '',
            $remember
        );
    }

    /**
     * ログアウト
     */
    public function logout(): void
    {
        $user = Auth::user();

        if ($user) {
            // 家族セッション情報をクリア
            $this->familyAuthService->destroyFamilySession($user);
        }

        // セッション情報をクリア
        Session::forget(['family_id', 'family_name', 'family_role']);
        Session::flush();

        Auth::logout();
        Session::regenerate();
    }

    /**
     * 現在認証されているユーザーを取得
     */
    public function user(): ?User
    {
        return Auth::user();
    }

    /**
     * 現在のユーザーの家族を取得
     */
    public function family(): ?Family
    {
        $user = $this->user();

        if (!$user || !$user->family_id) {
            return null;
        }

        return $this->userFamilyRepository->getUserFamily($user);
    }

    /**
     * 認証チェック
     */
    public function check(): bool
    {
        return Auth::check();
    }

    /**
     * 家族メンバーとしてログインしているかチェック
     */
    public function isFamilyMember(): bool
    {
        $user = $this->user();

        return $user && $user->family_id !== null;
    }
}
