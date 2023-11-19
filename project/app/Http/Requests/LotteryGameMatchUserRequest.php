<?php

namespace App\Http\Requests;

class LotteryGameMatchUserRequest extends Request
{
    public function rules($action)
    {
        switch ($action) {
            case 'create':
                return [
                    'user_id' => 'bail|required|int|exists:users,id',
                    'lottery_game_match_id' => 'bail|required|int|exists:lottery_game_matches,id'
                ];
        }
    }
}
