<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\FamilyRepositoryInterface;
use App\Repositories\FamilyRepository;
use App\Repositories\Contracts\FamilyInvitationRepositoryInterface;
use App\Repositories\FamilyInvitationRepository;
use App\Repositories\Contracts\UserFamilyRepositoryInterface;
use App\Repositories\UserFamilyRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Family Repository
        $this->app->bind(FamilyRepositoryInterface::class, FamilyRepository::class);

        // Family Invitation Repository
        $this->app->bind(FamilyInvitationRepositoryInterface::class, FamilyInvitationRepository::class);

        // User Family Repository
        $this->app->bind(UserFamilyRepositoryInterface::class, UserFamilyRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
