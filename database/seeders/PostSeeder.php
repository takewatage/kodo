<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\Post::factory(2)->create();
        \App\Models\Post::factory(2)->create([
            'group_id' => 1,
            'view_auth_type' => 1
        ]);
        \App\Models\Post::factory(2)->create([
            'group_id' => 1,
            'view_auth_type' => 2
        ]);
        \App\Models\Post::factory(2)->create([
            'view_auth_type' => 2
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
