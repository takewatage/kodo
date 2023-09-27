<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'テスト 太郎',
            'email' => 'test@test.com',
        ]);
        \App\Models\User::factory(10)->create();
    }
}
