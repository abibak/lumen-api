<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LotteryGameMatch extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'game_id',
        'winner_id',
        'start_date',
        'start_time',
        "is_finished",
    ];
}
