<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LotteryGameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            DB::table('lottery_games')->insert([
                'name' => 'Lottery ' . $i + 1,
                'gamer_count' => rand(3, 10),
                'reward_points' => rand(10, 100),
            ]);
        }
    }
}
