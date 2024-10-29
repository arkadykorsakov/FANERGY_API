<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSubscriptionSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		DB::table('user_subscriptions')
			->insert(
				[
					['subscriber_id' => 1, 'author_id' => 2],
					['subscriber_id' => 3, 'author_id' => 4],
					['subscriber_id' => 4, 'author_id' => 5],
					['subscriber_id' => 5, 'author_id' => 1],
					['subscriber_id' => 3, 'author_id' => 1],
				]
			);
	}
}
