<?php

namespace App\Repositories;

use App\Models\Family;
use App\Models\User;
use App\Repositories\Contracts\UserFamilyRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserFamilyRepository implements UserFamilyRepositoryInterface
{
    public function getUserFamily(User $user): ?Family
    {
        return $user->family;
    }

    public function getUsersByFamily(Family $family): Collection
    {
        return User::where('family_id', $family->id)
            ->orderBy('family_role')
            ->orderBy('joined_family_at')
            ->get();
    }

    public function getUsersByFamilyRole(Family $family, string $role): Collection
    {
        return User::where('family_id', $family->id)
            ->where('family_role', $role)
            ->orderBy('joined_family_at')
            ->get();
    }

    public function updateUserFamilyInfo(User $user, array $data): bool
    {
        $fillable = ['family_id', 'family_role', 'joined_family_at', 'family_permissions'];
        $updateData = array_intersect_key($data, array_flip($fillable));

        return $user->update($updateData);
    }

    public function removeUserFromFamily(User $user): bool
    {
        // オーナーの場合は削除できない
        if ($user->family && $user->family->owner_id === $user->id) {
            return false;
        }

        return $user->update([
            'family_id' => null,
            'family_role' => 'guest',
            'joined_family_at' => null,
            'family_permissions' => null,
        ]);
    }

    public function assignUserToFamily(User $user, Family $family, string $role = 'guest'): bool
    {
        // 既に家族に所属している場合
        if ($user->family_id !== null) {
            return false;
        }

        // 最大メンバー数チェック
        if ($this->getUsersByFamily($family)->count() >= $family->max_members) {
            return false;
        }

        return $user->update([
            'family_id' => $family->id,
            'family_role' => $role,
            'joined_family_at' => now(),
        ]);
    }

    public function updateUserPermissions(User $user, array $permissions): bool
    {
        return $user->update([
            'family_permissions' => $permissions,
        ]);
    }

    public function getUserPermissions(User $user): array
    {
        return $user->family_permissions ?? [];
    }
}
