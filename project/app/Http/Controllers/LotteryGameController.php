<?php

namespace App\Http\Controllers;

use App\Models\LotteryGame;

class LotteryGameController extends Controller
{
    public function index()
    {
        $lottery_games = LotteryGame::all();

        return response()->json([
            'data' => $lottery_games
        ], 200);
    }
}
