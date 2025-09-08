<?php
namespace App\Repositories\Contracts;

use App\Models\Family;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserFamilyRepositoryInterface
{
    public function getUserFamily(User $user): ?Family;

    public function getUsersByFamily(Family $family): Collection;

    public function getUsersByFamilyRole(Family $family, string $role): Collection;

    public function updateUserFamilyInfo(User $user, array $data): bool;

    public function removeUserFromFamily(User $user): bool;

    public function assignUserToFamily(User $user, Family $family, string $role = 'guest'): bool;

    public function updateUserPermissions(User $user, array $permissions): bool;

    public function getUserPermissions(User $user): array;
}
