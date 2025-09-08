<?php

namespace App\Services;

use App\Models\Family;
use App\Models\User;
use App\Repositories\Contracts\FamilyRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FamilyAuthService
{
    /**
     * 家族メンバーとしてログイン
     */
    public function loginAsFamilyMember(Family $family, string $email, string $password, bool $remember = false): ?User
    {
        // 家族メンバーの認証
        $user = $this->authenticateMember($family, $email, $password);

        if (!$user) {
            return null;
        }

        // ログイン処理
        Auth::login($user, $remember);

        // 家族セッションの作成
        $this->createFamilySession($user, $family);

        // セッション情報の設定
        Session::put('family_id', $family->id);
        Session::put('family_name', $family->name);
        Session::put('family_role', $user->family_role);
        Session::regenerate();

        return $user;
    }

    /**
     * 家族コードでの認証
     */
    public function authenticateByFamilyCode(string $code): ?Family
    {
        return Family::where('code', $code)->first();
    }

    /**
     * 家族メンバーの認証
     */
    public function authenticateMember(Family $family, string $email, string $password): ?User
    {
        // メールアドレスでユーザーを検索
        $user = User::where('email', $email)->first();

        if (!$user) {
            return null;
        }

        // パスワードの検証
        if (!Hash::check($password, $user->password)) {
            return null;
        }

        // 家族のメンバーかチェック
        if (!$this->isMemberOfFamily($user, $family)) {
            return null;
        }

        return $user;
    }

    /**
     * 家族の全メンバーを取得
     */
    public function getFamilyMembers(Family $family): Collection
    {
        return $this->familyRepository->getMembers($family);
    }

    /**
     * ユーザーが家族のメンバーかチェック
     */
    public function isMemberOfFamily(User $user, Family $family): bool
    {
        return $user->family_id === $family->id;
    }

    /**
     * 家族セッションの作成
     */
    public function createFamilySession(User $user, Family $family): string
    {
        $sessionToken = Str::random(64);

        // セッションに保存（実際のアプリケーションではDBに保存することも検討）
        Session::put('family_session_token', $sessionToken);
        Session::put('family_session_user_id', $user->id);
        Session::put('family_session_family_id', $family->id);
        Session::put('family_session_started_at', now());

        return $sessionToken;
    }

    /**
     * 家族セッションの削除
     */
    public function destroyFamilySession(User $user): void
    {
        Session::forget([
            'family_session_token',
            'family_session_user_id',
            'family_session_family_id',
            'family_session_started_at',
        ]);
    }
}
