<?php
namespace App\Repositories\Contracts;

use App\Models\Family;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface FamilyRepositoryInterface
{
    public function find(int $id): ?Family;

    public function findByCode(string $code): ?Family;

    public function create(array $data): Family;

    public function update(Family $family, array $data): bool;

    public function delete(Family $family): bool;

    public function getMembers(Family $family): Collection;

    public function getMemberCount(Family $family): int;

    public function addMember(Family $family, User $user, string $role = 'guest'): bool;

    public function removeMember(Family $family, User $user): bool;

    public function updateMemberRole(Family $family, User $user, string $role): bool;

    public function isMember(Family $family, User $user): bool;

    public function isOwner(Family $family, User $user): bool;

    public function generateUniqueCode(): string;
}
