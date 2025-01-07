<?php

namespace Database\Seeders;

use App\Models\Billing;
use App\Models\Goal;
use App\Models\Post;
use App\Models\SubscriptionLevel;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		User::create(
			[
				'name' => 'test_user',
				'email' => 'test.user@mail.ru',
				'phone' => '+7(923)9551154',
				'nickname' => 'test_user',
				'password' => bcrypt('test_password'),
				'description' => 'test description',
                'date_birth'=> fake()->date()
			]
		);
		User::create(
			[
				'name' => 'test_user1',
				'email' => 'test.user1@mail.ru',
				'phone' => '+7(922)9751155',
				'nickname' => 'test_user1',
				'password' => bcrypt('test_password_1'),
				'description' => 'test description 1',
                'date_birth'=> fake()->date()
			]
		);
		User::factory(3)->create();
		Tag::factory(20)->create();
		Post::factory(20)->create();
        Goal::factory(20)->create();
        Billing::factory(5)->create();
        SubscriptionLevel::factory(5)->create();
		$this->call([
			LikesForPostsSeeder::class,
			RepostsForPostsSeeder::class,
			UserSubscriptionSeeder::class,
			UserBlocklistSeeder::class
		]);
	}
}
