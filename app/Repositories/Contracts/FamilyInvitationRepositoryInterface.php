<?php
namespace App\Repositories\Contracts;

use App\Models\Family;
use App\Models\FamilyInvitation;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface FamilyInvitationRepositoryInterface
{
    public function find(int $id): ?FamilyInvitation;

    public function findByToken(string $token): ?FamilyInvitation;

    public function create(array $data): FamilyInvitation;

    public function delete(FamilyInvitation $invitation): bool;

    public function getByFamily(Family $family): Collection;

    public function getByEmail(string $email): Collection;

    public function getPendingByFamilyAndEmail(Family $family, string $email): ?FamilyInvitation;

    public function generateToken(): string;

    public function deleteExpiredInvitations(): int;
}
