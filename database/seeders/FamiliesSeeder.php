<?php

namespace Database\Seeders;

use App\Models\Family;
use App\Models\User;
use Illuminate\Database\Seeder;

class FamiliesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()->first();

        $family = Family::factory()->create([
            'name' => 'テストファミリー',
            'code' => 'testtest',
            'owner_id' => isset($user->id) ? $user->id : null,
        ]);

        if (isset($family->id)) {
            $user->family_id = $family->id;
        }
        $user->save();
    }
}
