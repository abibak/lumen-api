<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LotteryGameMatchUser extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'lottery_game_match_id',
    ];
}
