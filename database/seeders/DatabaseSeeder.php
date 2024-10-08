<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (config('app.env') === 'local') {
            $this->call([UserSeeder::class, TeamSeeder::class, TeamUserSeeder::class, TeamUserPostSeeder::class]);
        }
    }
}
