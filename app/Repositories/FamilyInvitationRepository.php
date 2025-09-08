<?php

namespace App\Repositories;

use App\Models\Family;
use App\Models\FamilyInvitation;
use App\Models\User;
use App\Repositories\Contracts\FamilyInvitationRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class FamilyInvitationRepository implements FamilyInvitationRepositoryInterface
{
    public function find(int $id): ?FamilyInvitation
    {
        return FamilyInvitation::find($id);
    }

    public function findByToken(string $token): ?FamilyInvitation
    {
        return FamilyInvitation::where('token', $token)->first();
    }

    public function create(array $data): FamilyInvitation
    {
        if (!isset($data['token'])) {
            $data['token'] = $this->generateToken();
        }

        return FamilyInvitation::create($data);
    }

    public function delete(FamilyInvitation $invitation): bool
    {
        return $invitation->delete();
    }

    public function getByFamily(Family $family): Collection
    {
        return FamilyInvitation::where('family_id', $family->id)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getByEmail(string $email): Collection
    {
        return FamilyInvitation::where('email', $email)->orderBy('created_at', 'desc')->get();
    }

    public function getPendingByFamilyAndEmail(Family $family, string $email): ?FamilyInvitation
    {
        return FamilyInvitation::where('family_id', $family->id)
            ->where('email', $email)
            ->latest()
            ->first();
    }

    public function generateToken(): string
    {
        do {
            $token = Str::random(64);
        } while (FamilyInvitation::where('token', $token)->exists());

        return $token;
    }

    public function deleteExpiredInvitations(): int
    {
        // 30日以上前の招待を削除
        return FamilyInvitation::where('created_at', '<', now()->subDays(30))->delete();
    }
}
