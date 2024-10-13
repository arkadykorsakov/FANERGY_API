<?php

namespace Database\Seeders;

use App\Models\Goal;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		// User::factory(10)->create();

		User::create(
			[
				'name' => 'test_user',
				'email' => 'test.user@mail.ru',
				'nickname' => 'test_user',
				'password' => bcrypt('test_password'),
				'description' => 'test description',
			]
		);
        User::create(
            [
                'name' => 'test_user1',
                'email' => 'test.user1@mail.ru',
                'nickname' => 'test_user1',
                'password' => bcrypt('test_password_1'),
                'description' => 'test description 1',
            ]
        );
        Tag::factory(20)->create();
        Post::factory(20)->create();
        Goal::factory(20)->create();
	}
}
