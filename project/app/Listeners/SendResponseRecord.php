<?php

namespace App\Listeners;

use App\Events\RecordingUserMatch;
use App\Models\LotteryGame;
use App\Models\LotteryGameMatch;
use App\Models\LotteryGameMatchUser;

class SendResponseRecord
{
    public function handle(RecordingUserMatch $event)
    {
        $user_find = LotteryGameMatchUser::where([
            ['user_id', '=', $event->user_id],
            ['lottery_game_match_id', '=', $event->match_id]
        ])->first();
        $get_lottery_id = LotteryGameMatch::select('game_id')->where('id', '=', $event->match_id)->first();
        // Макс. кол-во пользователей
        $gamer_count = LotteryGame::select('gamer_count')->where('id', '=', $get_lottery_id['game_id'])->first();
        // Кол-во записанных
        $recorded_count = LotteryGameMatchUser::where('lottery_game_match_id', '=', $event->match_id)->count();

        if ($user_find) {
            throw new \Exception('User already recorded.');
        }

        if ($recorded_count >= $gamer_count['gamer_count']) {
            throw new \Exception('Max recorded.');
        }
    }
}
