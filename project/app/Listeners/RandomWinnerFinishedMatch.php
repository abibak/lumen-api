<?php

namespace App\Listeners;

use App\Events\FinishedMatch;
use App\Models\LotteryGame;
use App\Models\LotteryGameMatch;
use App\Models\LotteryGameMatchUser;
use App\Models\User;

class RandomWinnerFinishedMatch
{
    public function __construct()
    {
        //
    }

    public function handle(FinishedMatch $event)
    {
        $users_in_match = LotteryGameMatchUser::select('user_id')->where('lottery_game_match_id', '=', $event->match_id)->get() ?? [];
        $random_winner = $users_in_match[rand(1, count($users_in_match) - 1)];
        $event->lottery_match->update(['winner_id' => $random_winner['user_id']]);

        $get_lottery_id = LotteryGameMatch::select('game_id')->where('id', '=', $event->match_id)->first();
        // Кол-во очков
        $reward_points = LotteryGame::select('reward_points')->where('id', '=', $get_lottery_id['game_id'])->first();

        User::where('id', '=', $random_winner['user_id'])->update(['points' => $reward_points['reward_points']]);
    }
}
