<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserBlocklistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_blocklists')
            ->insert(
                [
                    ['user_id' => 1, 'blocked_user_id' => 4],
                    ['user_id' => 2, 'blocked_user_id' => 3],
                    ['user_id' => 2, 'blocked_user_id' => 4],
                    ['user_id' => 2, 'blocked_user_id' => 5],
                ]
            );
    }
}
