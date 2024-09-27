<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\TeamUserPost;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamUserPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        // 現在の日付を基準に前後1週間分のデータを作成
        $startDate = Carbon::now()->subDays(7);  // 7日前
        $endDate = Carbon::now()->addDays(7);    // 7日後

        collect($users)->each(function ($user) use ($startDate, $endDate) {
            // ユーザーが所属するチームを取得
            $userTeams = $user->teams;
            $date = new Carbon($startDate);

            // 前後1週間の日付で毎日のデータを作成
            while ($date <= $endDate) {
                collect($userTeams)->each(function ($team) use ($user, $date) {
                    $post = Post::create([
                        'user_id' => $user->id,
                        'title' => '報告 - ' . $date->format('Y-m-d'),  // タイトルに日付を使う
                        'content' => 'この日は ' . $date->format('Y-m-d') . ' の報告です。',
                        'created_at' => $date,
                        'updated_at' => $date,
                    ]);

                    $post->teamUsers()->attach($team->id);
                });

                $date->addDay();
            }
        });
    }
}
