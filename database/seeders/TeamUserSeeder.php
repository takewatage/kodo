<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\TeamUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::all();

        collect($user)->each(function ($user) {
            $team = Team::inRandomOrder()->limit(1)->first();
            TeamUser::factory()->create([
                'team_id' => $team->id,
                'user_id' => $user->id,
            ]);
        });
    }
}
