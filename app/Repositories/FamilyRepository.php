<?php

namespace App\Repositories;

use App\Models\Family;
use App\Models\User;
use App\Repositories\Contracts\FamilyRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class FamilyRepository implements FamilyRepositoryInterface
{
    public function find(int $id): ?Family
    {
        return Family::find($id);
    }

    public function findByCode(string $code): ?Family
    {
        return Family::where('code', $code)->first();
    }

    public function create(array $data): Family
    {
        if (!isset($data['code'])) {
            $data['code'] = $this->generateUniqueCode();
        }

        return Family::create($data);
    }

    public function update(Family $family, array $data): bool
    {
        return $family->update($data);
    }

    public function delete(Family $family): bool
    {
        return $family->delete();
    }

    public function getMembers(Family $family): Collection
    {
        return $family->members()->orderBy('family_role')->orderBy('joined_family_at')->get();
    }

    public function getMemberCount(Family $family): int
    {
        return $family->members()->count();
    }

    public function addMember(Family $family, User $user, string $role = 'guest'): bool
    {
        // 既にメンバーの場合は false を返す
        if ($this->isMember($family, $user)) {
            return false;
        }

        // 最大メンバー数チェック
        if ($this->getMemberCount($family) >= $family->max_members) {
            return false;
        }

        $user->family_id = $family->id;
        $user->family_role = $role;
        $user->joined_family_at = now();

        return $user->save();
    }

    public function removeMember(Family $family, User $user): bool
    {
        // オーナーは削除できない
        if ($this->isOwner($family, $user)) {
            return false;
        }

        if (!$this->isMember($family, $user)) {
            return false;
        }

        $user->family_id = null;
        $user->family_role = 'guest';
        $user->joined_family_at = null;
        $user->family_permissions = null;

        return $user->save();
    }

    public function updateMemberRole(Family $family, User $user, string $role): bool
    {
        if (!$this->isMember($family, $user)) {
            return false;
        }

        // オーナーの役割は変更できない
        if ($this->isOwner($family, $user) && $role !== 'owner') {
            return false;
        }

        $user->family_role = $role;

        return $user->save();
    }

    public function isMember(Family $family, User $user): bool
    {
        return $user->family_id === $family->id;
    }

    public function isOwner(Family $family, User $user): bool
    {
        return $family->owner_id === $user->id;
    }

    public function generateUniqueCode(): string
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (Family::where('code', $code)->exists());

        return $code;
    }
}
