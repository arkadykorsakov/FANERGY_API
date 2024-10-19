<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RepostsForPostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::all();
        $users = User::all();

        foreach ($posts as $post) {
            $eligibleUsers = $users->where('id', '!=', $post->user_id);

            $repostsCount = rand(1, 5);

            for ($i = 0; $i < $repostsCount; $i++) {

                $user = $eligibleUsers->random();
                DB::table('reposts_for_posts')->insert([
                    'user_id' => $user->id,
                    'post_id' => $post->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
