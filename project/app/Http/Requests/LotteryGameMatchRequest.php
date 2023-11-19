<?php

namespace App\Http\Requests;

class LotteryGameMatchRequest extends Request
{
    public function rules($action)
    {
        switch ($action) {
            case 'create':
                return [
                    'game_id' => 'bail|int|required|exists:lottery_games,id',
                    'start_date' => 'bail|string|date',
                    'start_time' => 'bail|required',
                ];
        }
    }
}
