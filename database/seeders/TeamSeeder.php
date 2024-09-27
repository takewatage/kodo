<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([1,1])->each(function($x, $i) {
            Team::factory()->create([
                'name' => 'チーム'. $i
            ]);
        });
    }
}
